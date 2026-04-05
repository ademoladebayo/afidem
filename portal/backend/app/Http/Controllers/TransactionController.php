<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service\TransactionService;
use App\Service\AdminService;
use App\Model\ExpenseModel;
use Carbon\Carbon;

class TransactionController extends Controller
{
    // SIGNIN
    public function signIn(Request $request)
    {
        $AdminService = new AdminService();
        return $AdminService->signIn($request);
    }

    // EXPENSE MANAGEMENT
    public function createExpense(Request $request)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->createExpense($request);

    }

    public function editExpense(Request $request)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->editExpense($request);
    }

    public function allExpense(Request $request)
    {
        $date = explode("~", $request->date);
        $start_date = Carbon::parse($date[0]);
        $end_date = Carbon::parse($date[1]);
        return ExpenseModel::whereBetween('date', [$start_date, $end_date])->where('admin_station', $request->admin_station)->orderBy('id', 'DESC')->get();
        // $month = explode("-", $request->date)[0] . "-" . explode("-", $request->date)[1];
        // return ExpenseModel::where('date', 'like', $month . '%')->where('admin_station', $request->admin_station)->orderBy('id', 'DESC')->get();
    }
    public function deleteExpense($fee_id)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->deleteExpense($fee_id);
    }

    public function uploadReport(Request $request)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->uploadReport($request);
    }

    public function fetchTransaction(Request $request)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->fetchTransaction($request);
    }

    public function deleteTransaction($id)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->deleteTransaction($id);
    }

    public function uploadProfit(Request $request)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->uploadProfit($request);
    }

    public function getFinancialSummary(Request $request)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->getFinancialSummary($request);
    }

    public function getBreakdown(Request $request)
    {
        $TransactionService = new TransactionService();
        return $TransactionService->getBreakdown($request);
    }
}
