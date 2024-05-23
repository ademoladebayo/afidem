<?php

namespace App\Service;

use App\Http\Controllers\NotificationController;
use App\Model\LoanModel;
use App\Model\AdminModel;
use App\Model\ExpenseModel;
use App\Model\TransactionModel;
use App\Model\UserModel;
use App\Util\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class LoanService
{


    public function createLoan(Request $request)
    {
        $LoanModel = new LoanModel();
        $LoanModel->user_id = $request->user_id;
        $LoanModel->amount = $request->amount;
        $LoanModel->duration = $request->duration;
        $LoanModel->loan_type = $request->loan_type;
        $LoanModel->rate = $request->rate;
        $LoanModel->commission = $request->commission;
        $LoanModel->disbursement_date = $request->disbursement_date;
        $LoanModel->due_date = $request->due_date;
        $LoanModel->collateral = $request->collateral;
        $LoanModel->status = "NOT PAID";
        // $LoanModel->created_at = "NOT PAID";
        // $LoanModel->updated_at = "NOT PAID";
        $LoanModel->save();


        $deviceTokens = AdminModel::select('device_token')
            ->where('role', 'SUPERADMIN')
            ->get();

        $receiver = [];

        foreach ($deviceTokens as $token) {
            $receiver[] = $token->device_token;
        }
        ;

        NotificationController::createNotification(Utils::getUserLoggedIn($request) . ' JUST CREATED A ', $request->txn_type . ' Loan TRANSACTION OF  ₦' . number_format($request->amount), $receiver);
        return response(['success' => true, 'message' => "Loan transaction was added successfully."]);
    }

    public function updateLoan(Request $request)
    {
        $LoanModel = LoanModel::find($request->id);
        $LoanModel->user_id = $request->user_id;
        $LoanModel->amount = $request->amount;
        $LoanModel->duration = $request->duration;
        $LoanModel->loan_type = $request->loan_type;
        $LoanModel->rate = $request->rate;
        $LoanModel->commission = $request->commission;
        $LoanModel->disbursement_date = $request->disbursement_date;
        $LoanModel->due_date = $request->due_date;
        $LoanModel->collateral = $request->collateral;
        $LoanModel->status = $request->status;
        $LoanModel->save();

        return response(['success' => true, 'message' => "Loan transaction was updated successfully."]);
    }


    public function fetchLoan($from, $to, $user_id = null)
    {
        $month = explode("-", $from)[0] . "-" . explode("-", $from)[1];
        $start_date = $from . " 00:00:00";
        $end_date = $to . " 23:59:00";
        $user_id = $user_id == '0' ? null : $user_id;

        $data =
            [
                'debitor' => $this->processFetchLoan('DEBITOR', $user_id, $start_date, $end_date),

                'creditor' => $this->processFetchLoan('CREDITOR', $user_id, $start_date, $end_date)
            ];

        return response(['success' => true, 'data' => $data]);
    }


    public function processFetchLoan($type, $user_id, $start_date, $end_date)
    {
        if ($user_id) {
            $loanTXN = LoanModel::with('user')->where('user_id', $user_id)->where('loan_type', $type)->whereBetween('disbursement_date', [$start_date, $end_date]);
        } else {
            $loanTXN = LoanModel::with('user')->where('loan_type', $type)->whereBetween('disbursement_date', [$start_date, $end_date]);
        }


        $totalUsers = clone $loanTXN;
        $totalUsers = $totalUsers->distinct()->pluck('user_id')->toArray();

        $total_amount = clone $loanTXN;
        $total_amount = $total_amount->where('status', 'PAID')->sum('amount');

        $total_commission = clone $loanTXN;
        $total_commission = $total_commission->where('status', 'PAID')->sum('commission');

        $unpaid = clone $loanTXN;
        $unpaid = $unpaid->where('status', 'NOT PAID')->sum('amount');


        return [
            'total_user' => count($totalUsers),
            'total_amount' => $total_amount,
            'total_commission' => $total_commission,
            'unpaid' => $unpaid,
            'data' => $loanTXN->get(),

        ];

    }

}
