<?php

namespace App\Service;

use App\Http\Controllers\NotificationController;
use App\Model\AjoModel;
use App\Model\AdminModel;
use App\Model\ExpenseModel;
use App\Model\TransactionModel;
use App\Model\UserModel;
use App\Util\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class AjoService
{


    public function createTransaction(Request $request)
    {
        $AjoModel = new AjoModel();
        $AjoModel->user_id = $request->user_id;
        $AjoModel->date = $request->date;
        $AjoModel->txn_type = $request->txn_type;
        $AjoModel->amount = $request->amount;
        $curr_bal = $this->getUserBalance($request->user_id);
        $AjoModel->bal_before = $curr_bal;

        if ($request->txn_type == "DEBIT") {
            if ($request->amount > $curr_bal) {
                return response(['success' => false, 'message' => "Insufficent Fund !"]);
            }
        } else {
            //SAME DAY TRANSACTION CHECK FOR CREDIT TRANSACTIONS
            if (AjoModel::where('txn_type', 'CREDIT')->where('user_id', $request->user_id)->where('date', $request->date)->exist()) {
                return response(['success' => false, 'message' => "User already have an Ajo for this day " . $request->date]);
            }
        }


        $isFirstDepositOfTheMonth = $this->isFirstDepositOfTheMonth($request->user_id, $request->date, $request->amount);

        $isAmountSameOfTheMonth = $this->isAmountSameOfTheMonth($request->user_id, $request->date, $request->amount);

        if ($request->txn_type == 'CREDIT') {
            if (!$isAmountSameOfTheMonth) {
                return response(['success' => false, 'message' => "Invalid amount for this user !"]);
            }
        } else {
            if ($curr_bal < $request->amount) {
                response(['success' => false, 'message' => "Insufficent balance !"]);
            }

        }


        if ($isFirstDepositOfTheMonth) {
            $AjoModel->is_charge = true;
        }

        $AjoModel->save();

        $AjoModel->bal_after = $this->getUserBalance($request->user_id);
        $AjoModel->save();

        $deviceTokens = AdminModel::select('device_token')
            ->where('role', 'SUPERADMIN')
            ->get();

        $receiver = [];

        foreach ($deviceTokens as $token) {
            $receiver[] = $token->device_token;
        }
        ;

        NotificationController::createNotification(Utils::getUserLoggedIn($request) . ' JUST CREATED A ', $request->txn_type . ' AJO TRANSACTION OF  ₦' . number_format($request->amount), $receiver);
        return response(['success' => true, 'message' => "Ajo transaction was added successfully."]);
    }



    public function fetchTransaction($from, $to, $user_id = null)
    {

        $month = explode("-", $from)[0] . "-" . explode("-", $from)[1];
        $start_date = $from . " 00:00:00";
        $end_date = $to . " 23:59:00";
        $user_id = $user_id == '-' ? null : $user_id;
        \Log::info("USER ID :: " . $user_id);

        if ($user_id) {
            $ajoTxn = AjoModel::with('user')->where('user_id', $user_id)->whereBetween('date', [$start_date, $end_date]);
        } else {
            $ajoTxn = AjoModel::with('user')->whereBetween('date', [$start_date, $end_date]);
        }

        $totalUsers = clone $ajoTxn;
        $totalUsers = $totalUsers->distinct()->pluck('user_id')->toArray();
        \Log::info(print_r($totalUsers, true));

        $contributionCount = clone $ajoTxn;
        $contributionCount = $contributionCount->count();

        $totalCredit = clone $ajoTxn;
        $totalCredit = $totalCredit->where('txn_type', 'CREDIT')->sum('amount');

        $totalDebit = clone $ajoTxn;
        $totalDebit = $totalDebit->where('txn_type', 'DEBIT')->sum('amount');

        $totalCharge = clone $ajoTxn;
        $totalCharge = $totalCharge->where('is_charge', true)->sum('amount');

        $balance = $totalCredit - $totalDebit;
        $availableBalance = $balance - $totalCharge;


        $data =
            [
                "total_user" => count($totalUsers),
                "contribution_count" => $contributionCount,
                "total_credit" => $totalCredit,
                "total_debit" => $totalDebit,
                "profit" => $totalCharge,
                "balance" => $balance,
                "available_balance" => $availableBalance,
                "txn_history" => $ajoTxn->get(),
                "txn_summary" => $this->getTransactionSummary($start_date, $end_date, $totalUsers)
            ];
        return response(['success' => true, 'message' => "Data fetched successfully", 'data' => $data]);
    }



    public function isFirstDepositOfTheMonth($user_id, $date, $amount)
    {
        $month = explode("-", $date)[0] . "-" . explode("-", $date)[1];
        $ajoTxn = AjoModel::where('user_id', $user_id)->where('date', 'like', $month . '%')->get();

        if (count($ajoTxn) == 0) {
            return true;
        }
        return false;
    }


    public function isAmountSameOfTheMonth($user_id, $date, $amount)
    {
        $month = explode("-", $date)[0] . "-" . explode("-", $date)[1];
        $ajoTxn = AjoModel::where('user_id', $user_id)->where('date', 'like', $month . '%')->get();

        if (count($ajoTxn) > 0) {
            $ajoTxn = $ajoTxn->first();
            if ($ajoTxn->amount == $amount) {
                return true;
            } else {
                return false;
            }

        } else {

            return true;
        }

    }


    public function getTransactionSummary($start_date, $end_date, $users)
    {
        $transactions = [];
        foreach ($users as $user) {
            \Log::info(print_r($user, true));
            $tx = $this->getUserBalance($user, $start_date, $end_date, false);
            array_push($transactions, $tx);
        }
        return $transactions;
    }


    public function getUserBalance($user_id, $start_date = null, $end_date = null, $figure = true)
    {
        if ($start_date == null) {
            $accountStatement = AjoModel::with('user')->where('user_id', $user_id);
        } else {
            $accountStatement = AjoModel::with('user')->where('user_id', $user_id)->whereBetween('date', [$start_date, $end_date]);
        }

        $totalCredit = clone $accountStatement;
        $totalCredit = $totalCredit->where('txn_type', 'CREDIT')->sum('amount');

        $totalDebit = clone $accountStatement;
        $totalDebit = $totalDebit->where('txn_type', 'DEBIT')->sum('amount');

        $totalCharge = clone $accountStatement;
        $totalCharge = $totalCharge->where('is_charge', true)->sum('amount');

        $balance = $totalCredit - $totalDebit;
        $availableBalance = $balance - $totalCharge;


        if ($figure) {
            return $availableBalance;
        }

        $stat =
            [
                "user" => $accountStatement->first()->user, //UserModel::find($user_id)->select('first_name', 'last_name')->first(),
                "total_credit" => $totalCredit,
                "total_debit" => $totalDebit,
                "total_charge" => $totalCharge,
                "balance" => $balance,
                "available_balance" => $availableBalance,
            ];

        return $stat;
    }











}
