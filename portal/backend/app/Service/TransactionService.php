<?php

namespace App\Service;

use Illuminate\Http\Request;
use App\Model\ExpenseModel;
use App\Model\TransactionModel;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransactionImport;
use App\Model\AdminModel;
use App\Http\Controllers\NotificationController;
use App\Util\Utils;
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

        $deviceTokens = AdminModel::select('device_token')
            ->where('role', 'SUPERADMIN')
            ->get();

        $receiver = [];

        foreach ($deviceTokens as $token) {
            $receiver[] = $token->device_token;
        };

        NotificationController::createNotification(Utils::getUserLoggedIn($request) . ' JUST ADDED A NEW EXPENSE ', $request->description . ' ₦' . number_format($request->amount), $receiver);
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

        Log::debug($request->report_type);
        if ($request->report_type === "MANUAL") {
            return $this->uploadReportManual($request);
        } else {
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
                if (trim($row["status"] == "COMPLETED")) {

                    //CHECK IF TERMIAL BELONG TO THIS STATION
                    $terminal_id = AdminModel::where('id', $admin_station)->value('terminal_id');

                    if (trim($row["terminal_id"]) != "") {
                        if (trim($row["terminal_id"]) != $terminal_id) {
                            return response(['success' => false, 'message' => "Transactions does not belong to this terminal !"]);
                        }
                    }


                    if (TransactionModel::where('transaction_ref', trim($row["transaction_ref"]))->exists()) {
                        continue;
                    }


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
                    $transaction->comment = "NO COMMENT";
                    $transaction->report_type = "UPLOAD";
                    $transaction->admin_station = $admin_station;
                    $transaction->save();
                    $c = $c + 1;
                }
            }

            if ($c > 0) {
                return response(['success' => true, 'message' => "(" . $c . ") new transaction has been uploaded successfully  for " . $day]);
            } else {
                return response(['success' => false, 'message' => "Transactions has been uploaded before."]);
            }
        }
    }

    public function deleteTransaction($id)
    {
        TransactionModel::destroy($id);
        return response(['success' => true, 'message' => "Transaction was deleted successfully."]);
    }


    public function uploadReportManual(Request $request)
    {
        $data = $request->data;
        $transaction = new TransactionModel();
        foreach ($data as $key => $value) {
            if ($value != null || $value != "") {
                $transaction[$key] = $value;
            }
        }
        $transaction->save();
        return response()->json(['success' => true, 'message' => 'Transaction has been added successfully']);
    }

    public function fetchTransaction(Request $request)
    {
        $month = explode("-", $request->date)[0] . "-" . explode("-", $request->date)[1];
        $start_date = explode("~", $request->date)[0] . " 00:00:00";
        $end_date = explode("~", $request->date)[1] . " 23:59:00";

        $ALLOWED_REPORT_TYPE = TransactionModel::whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->exists();

        if ($ALLOWED_REPORT_TYPE) {
            $ALLOWED_REPORT_TYPE = TransactionModel::whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->first()->report_type;
        } else {
            $ALLOWED_REPORT_TYPE = "ANY";
        }


        $daily_stat = [
            'withdrawal' => TransactionModel::where("transaction_type", "WITHDRAWAL")->whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->sum("profit"),

            'card_transfer' => TransactionModel::where("transaction_type", "CARD_TRANSFER")->whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->sum("profit"),

            'transfer' => TransactionModel::where("transaction_type", "TRANSFER")->whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->sum("profit"),

            'airtime' => TransactionModel::where("transaction_type", "AIRTIME")->whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->sum("profit"),

            'purchase' => TransactionModel::where("transaction_type", "PURCHASE")->whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->sum("profit"),

            'pos_transfer' => TransactionModel::where("transaction_type", "POS_TRANSFER")->whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->sum("profit"),

            'trans_count' => TransactionModel::whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->count("id")
        ];

        $monthly_stat = [
            'withdrawal' => TransactionModel::where("transaction_type", "WITHDRAWAL")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->where("admin_station", $request->admin_station)->sum("profit"),

            'card_transfer' => TransactionModel::where("transaction_type", "CARD_TRANSFER")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'transfer' => TransactionModel::where("transaction_type", "TRANSFER")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'airtime' => TransactionModel::where("transaction_type", "AIRTIME")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'purchase' => TransactionModel::where("transaction_type", "PURCHASE")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'pos_transfer' => TransactionModel::where("transaction_type", "POS_TRANSFER")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'expense' => ExpenseModel::where('date', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("amount"),

            'trans_count' => TransactionModel::where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->count("id"),
        ];

        return ['ALLOWED_REPORT_TYPE' => $ALLOWED_REPORT_TYPE,  'daily_stat' => $daily_stat, 'montly_stat' => $monthly_stat, 'transaction_history' => TransactionModel::whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->orderBy("id", "DESC")->get()];
    }



    public function uploadProfit(Request $request)
    {
        $data = request()->all();
        foreach ($data as $keys => $value) {
            $transaction = TransactionModel::find($keys);
            foreach ($data[$keys] as $key => $value) {
                if ($value != null) {
                    $transaction[$key] = $value;
                }
            }
            $transaction->save();
        }
        return response()->json(['success' => true, 'message' => 'Profit has successfully been recorded']);
    }

    public function getFinancialSummary(Request $request)
    {
        $month = $request->date;
        $year = explode("-", $month)[0];
        $financial_summary = [];

        $stations = AdminModel::where("role", "ADMIN")->get();

        foreach ($stations as $station) {
            $m_income = TransactionModel::where('transaction_time', 'like', $month . '%')->where("admin_station", $station->id)->sum("profit");
            $m_expense = ExpenseModel::where('date', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("amount");
            $m_gross_profit = $m_income - $m_expense;

            $y_income = TransactionModel::where('transaction_time', 'like', $year . '%')->where("admin_station", $station->id)->sum("profit");
            $y_expense = ExpenseModel::where('date', 'like', $year . '%')->where("admin_station", $request->admin_station)->sum("amount");
            $y_gross_profit = $y_income - $y_expense;

            $data = [
                "station_name" => $station->username,
                "monthly" => [
                    "income" => intval($m_income),
                    "expense" =>  intval($m_expense),
                    "gross_profit" => intval($m_gross_profit)
                ],
                "yearly" => [
                    "income" => intval($y_income),
                    "expense" =>  intval($y_expense),
                    "gross_profit" => intval($y_gross_profit)
                ]
            ];
            array_push($financial_summary, $data);
        }

        return $financial_summary;
    }
}
