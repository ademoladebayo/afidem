<?php

namespace App\Service;

use App\Http\Controllers\NotificationController;
use App\Model\AjoModel;
use App\Model\AdminModel;
use App\Model\ExpenseModel;
use App\Model\TransactionModel;
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
        $AjoModel->bal_before = $this->getUserBalance($request->user_id);

        $isFirstDepositOfTheMonth = $this->isFirstDepositOfTheMonth($request->user_id, $request->date, $request->amount);

        $isAmountSameOfTheMonth = $this->isAmountSameOfTheMonth($request->user_id, $request->date, $request->amount);


        if (!$isAmountSameOfTheMonth) {
            return response(['success' => false, 'message' => "Invalid amount for this user !"]);
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

        if ($user_id) {
            $ajoTxn = AjoModel::with('user')->where('user_id', $user_id)->whereBetween('date', [$start_date, $end_date]);
        } else {
            $ajoTxn = AjoModel::with('user')->whereBetween('date', [$start_date, $end_date]);
        }


        $totalUsers = $ajoTxn->select('user_id')->distinct()->count();
        $contributedToday = $ajoTxn->count();
        $totalCredit = $ajoTxn->where(['txn_type' => 'CREDIT'])->sum('amount');
        $totalDebit = $ajoTxn->where('txn_type', 'DEBIT')->sum('amount');
        $totalCharge = $ajoTxn->where(['is_charge' => 1])->sum('amount');
        $balance = $totalCredit - $totalDebit;
        $availableBalance = $balance - $totalCharge;


        $data =
            [
                "total_user" => $totalUsers,
                "contributed_today" => $contributedToday,
                "total_credit" => $totalCredit,
                "total_debit" => $totalDebit,
                "profit" => $totalCharge,
                "balance" => $balance,
                "available_balance" => $availableBalance,
                "txn_history" => $ajoTxn->get()
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

    public function getUserBalance($user_id, $figure = true)
    {
        $accountStatement = AjoModel::where('user_id', $user_id);
        $totalCredit = $accountStatement->where(['txn_type' => 'CREDIT'])->sum('amount');
        $totalDebit = $accountStatement->where('txn_type', 'DEBIT')->sum('amount');
        $totalCharge = $accountStatement->where(['is_charge' => 1])->sum('amount');
        $balance = $totalCredit - $totalDebit;
        $availableBalance = $balance - $totalCharge;

        $stat =
            [
                "total_credit" => $totalCredit,
                "total_debit" => $totalDebit,
                "total_charge" => $totalCharge,
                "balance" => $balance,
                "available_balance" => $availableBalance,
            ];

        if ($figure) {
            return $availableBalance;
        }

        return $stat;
    }











}
