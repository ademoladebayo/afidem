<?php

namespace App\Service;

use Illuminate\Http\Request;
use App\Model\ExpenseModel;
use App\Model\TransactionModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransactionImport;
use Illuminate\Support\Facades\Log;

class TransactionService
{

    // EXPENSE MANAGEMENT
    public function createExpense(Request $request)
    {
        $ExpenseModel = new ExpenseModel();
        $ExpenseModel->description = $request->description;
        $ExpenseModel->date = $request->date_incurred;
        $ExpenseModel->amount = $request->amount;

        $ExpenseModel->admin_station = $request->admin_station;
        $ExpenseModel->save();
        return response(['success' => true, 'message' => "Expense was added successfully."]);
    }

    public function editExpense(Request $request)
    {
        $ExpenseModel = ExpenseModel::find($request->expense_id);
        $ExpenseModel->description = $request->description;
        $ExpenseModel->date = $request->date_incurred;
        $ExpenseModel->amount = $request->amount;
        $ExpenseModel->save();
        return response(['success' => true, 'message' => "Expense was updated successfully."]);
    }

    public function DeleteExpense($expense_id)
    {
        ExpenseModel::destroy($expense_id);
        return response(['success' => true, 'message' => "Expense was deleted successfully."]);
    }


    public function uploadReport(Request $request)
    {
        $file = $request->file('file');
        $admin_station = $request->admin_station;

        $import = new TransactionImport();
        $importedData = Excel::toArray($import, $file);

        // Get the first sheet from the imported data
        $sheetData = $importedData[0];


        // Iterate over the rows in the sheet
        $c = 0;
        $day = "";
        foreach ($sheetData as $row) {
            if (TransactionModel::where('transaction_ref', trim($row["transaction_ref"]))->exists()) {
                continue;
            }

            if (trim($row["status"] == "COMPLETED")) {
                $transaction = new TransactionModel();
                $day = explode(" ", trim($row["transaction_time"]))[0];
                $transaction->transaction_type = trim($row["transaction_type"]);
                $transaction->amount = trim($row["amount"]);
                $transaction->status = trim($row["status"]);
                $transaction->payer = trim($row["payer"]);
                $transaction->payer_fi = trim($row["payer_fi"]);
                $transaction->payee = trim($row["payee"]);
                $transaction->payee_fi = trim($row["payee_fi"]);
                $transaction->transaction_time = trim($row["transaction_time"]);
                $transaction->transaction_ref = trim($row["transaction_ref"]);
                $transaction->earnings = trim($row["earnings"]);
                $transaction->terminal_id = trim($row["terminal_id"]);
                $transaction->admin_station = $admin_station;
                $transaction->save();
                $c = $c + 1;
            }
        }

        if ($c > 0) {
            return response(['success' => true, 'message' => "(" . $c . ") new transaction has been uploaded successfully  for " . $day]);
        } else {
            return response(['success' => false, 'message' => "No transaction was uploaded"]);
        }
    }

    public function fetchTransaction(Request $request)
    {
        $month = explode("-", $request->date)[0] . "-" . explode("-", $request->date)[1];

        $daily_stat = [
            'withdrawal' => TransactionModel::where("transaction_type", "WITHDRAWAL")->where('transaction_time', 'like', $request->date . '%')->where("admin_station", $request->admin_station)->sum("profit"), 'card_transfer' => TransactionModel::where("transaction_type", "CARD_TRANSFER")->where('transaction_time', 'like', $request->date . '%')->where("admin_station", $request->admin_station)->sum("profit"), 'transfer' => TransactionModel::where("transaction_type", "TRANSFER")->where('transaction_time', 'like', $request->date . '%')->where("admin_station", $request->admin_station)->sum("profit"), 'airtime' => TransactionModel::where("transaction_type", "AIRTIME")->where('transaction_time', 'like', $request->date . '%')->where("admin_station", $request->admin_station)->sum("profit"), 'purchase' => TransactionModel::where("transaction_type", "PURCHASE")->where('transaction_time', 'like', $request->date . '%')->where("admin_station", $request->admin_station)->sum("profit"),
            'trans_count' => TransactionModel::where('transaction_time', 'like', $request->date . '%')->where("admin_station", $request->admin_station)->count("id")
        ];

        $monthly_stat = [
            'withdrawal' => TransactionModel::where("transaction_type", "WITHDRAWAL")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->where("admin_station", $request->admin_station)->sum("profit"), 'card_transfer' => TransactionModel::where("transaction_type", "CARD_TRANSFER")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"), 'transfer' => TransactionModel::where("transaction_type", "TRANSFER")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"), 'airtime' => TransactionModel::where("transaction_type", "AIRTIME")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"), 'purchase' => TransactionModel::where("transaction_type", "PURCHASE")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),
            'expense' => ExpenseModel::where('date', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("amount"),
            'trans_count' => TransactionModel::where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->count("id"),
        ];

        return ['daily_stat' => $daily_stat, 'montly_stat' => $monthly_stat, 'transaction_history' => TransactionModel::where('transaction_time', 'like', $request->date . '%')->where("admin_station", $request->admin_station)->orderBy("id", "DESC")->get()];
    }



    public function uploadProfit(Request $request)
    {
        $data = request()->all();
        foreach ($data as $keys => $value) {
            $transaction = TransactionModel::find($keys);
            foreach ($data[$keys] as $key => $value) {
                $transaction[$key] = $value == null ? "-" : $value;
            }
            $transaction->save();
        }
        return response()->json(['success' => true, 'message' => 'Profit has successfully been recorded']);
    }
}
