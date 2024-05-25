<?php

namespace App\Service;

use App\Http\Controllers\NotificationController;
use App\Imports\TransactionImport;
use App\Model\AdminModel;
use App\Model\AjoModel;
use App\Model\ExpenseModel;
use App\Model\LoanModel;
use App\Model\RoomModel;
use App\Model\TransactionModel;
use App\Util\Utils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

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
        }
        ;

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

            // Assuming the row index you want to use as headers is 6
            $headerRow = $sheetData[6]; // Index is 6 because array indexes start from 0

            // Iterate over the rows in the sheet starting from the 6th row (index 5)
            $c = 0;
            for ($i = 7; $i < count($sheetData); $i++) {
                $row = $sheetData[$i];

                // Create an associative array mapping column names to their respective values
                $rowData = array_combine($headerRow, $row);
                Log::debug($rowData);

                if (trim($rowData["Transaction Status"]) == "COMPLETED") {

                    //CHECK IF TERMIAL BELONG TO THIS STATION
                    $terminal_id = AdminModel::where('id', $admin_station)->value('terminal_id');
                    $terminal_ids = explode(",", $terminal_id);

                    if (trim($rowData["Terminal ID"]) != "") {
                        if (!in_array(trim($rowData["Terminal ID"]), $terminal_ids)) {
                            return response(['success' => false, 'message' => "Transactions does not belong to this terminal !"]);
                        }
                    }

                    if (TransactionModel::where('transaction_ref', trim($rowData["Transaction Ref"]))->exists()) {
                        continue;
                    }

                    $transaction = new TransactionModel();
                    $day = $this->excelDateTimeToUnix(trim($rowData["Date"]));
                    $transaction->transaction_type = trim($rowData["Transaction Type"]);
                    $transaction->amount = trim($rowData["Transaction Amount (NGN)"]);
                    $transaction->status = trim($rowData["Transaction Status"]);
                    $transaction->payer = trim($rowData["Source"]);
                    $transaction->payer_fi = trim($rowData["Source Institution"]);
                    $transaction->payee = trim($rowData["Beneficiary"]);
                    $transaction->payee_fi = trim($rowData["Beneficiary Institution"]);
                    $transaction->transaction_time = $day;
                    $transaction->transaction_ref = trim($rowData["Transaction Ref"]);
                    $transaction->earnings = trim($rowData["Settlement Debit (NGN)"]) == 0 ? 'CR ' . trim($rowData["Settlement Credit (NGN)"]) : 'DR ' . trim($rowData["Settlement Debit (NGN)"]);
                    $transaction->terminal_id = trim($rowData["Terminal ID"]);
                    $transaction->comment = "NO COMMENT";
                    $transaction->report_type = "UPLOAD";
                    $transaction->admin_station = $admin_station;
                    $transaction->save();
                    $c = $c + 1;

                    $day = explode(' ', $day)[0];
                }
            }

            if ($c > 0) {
                return response(['success' => true, 'message' => "(" . $c . ") new transaction has been uploaded successfully  for " . $day]);
            } else {
                return response(['success' => false, 'message' => "Transactions has been uploaded before."]);
            }
        }
    }

    public function excelDateTimeToUnix($excelDate)
    {
        // Convert Excel date to Unix timestamp
        $unixTimestamp = ($excelDate - 25569) * 86400;

        // Create a DateTime object from the Unix timestamp
        $date = new \DateTime("@$unixTimestamp");

        // Format the date as needed
        $formattedDate = $date->format('Y-m-d H:i:s');

        return $formattedDate;
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

            'bill_payment' => TransactionModel::where("transaction_type", "BILL_PAYMENT")->whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->sum("profit"),

            'trans_count' => TransactionModel::whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->count("id"),
        ];

        $monthly_stat = [
            'withdrawal' => TransactionModel::where("transaction_type", "WITHDRAWAL")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->where("admin_station", $request->admin_station)->sum("profit"),

            'card_transfer' => TransactionModel::where("transaction_type", "CARD_TRANSFER")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'transfer' => TransactionModel::where("transaction_type", "TRANSFER")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'airtime' => TransactionModel::where("transaction_type", "AIRTIME")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'purchase' => TransactionModel::where("transaction_type", "PURCHASE")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'pos_transfer' => TransactionModel::where("transaction_type", "POS_TRANSFER")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'bill_payment' => TransactionModel::where("transaction_type", "BILL_PAYMENT")->where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("profit"),

            'expense' => ExpenseModel::where('date', 'like', $month . '%')->where("admin_station", $request->admin_station)->sum("amount"),

            'trans_count' => TransactionModel::where('transaction_time', 'like', $month . '%')->where("admin_station", $request->admin_station)->count("id"),
        ];

        return ['ALLOWED_REPORT_TYPE' => $ALLOWED_REPORT_TYPE, 'daily_stat' => $daily_stat, 'montly_stat' => $monthly_stat, 'transaction_history' => TransactionModel::whereBetween('transaction_time', [$start_date, $end_date])->where("admin_station", $request->admin_station)->orderBy("id", "DESC")->get()];
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

            if (!in_array($station->username, ['AJO', 'SERVICE ROOM', 'LOAN'])) {
                $m_income = TransactionModel::where('transaction_time', 'like', $month . '%')->where("admin_station", $station->id)->sum("profit");
                $m_expense = ExpenseModel::where('date', 'like', $month . '%')->where("admin_station", $station->id)->sum("amount");
                $m_gross_profit = $m_income - $m_expense;

                $y_income = TransactionModel::where('transaction_time', 'like', $year . '%')->where("admin_station", $station->id)->sum("profit");
                $y_expense = ExpenseModel::where('date', 'like', $year . '%')->where("admin_station", $station->id)->sum("amount");
                $y_gross_profit = $y_income - $y_expense;
            } else {
                if ($station->username == 'AJO') {
                    $m_income = AjoModel::where('date', 'like', $month . '%')->where("is_charge", true)->sum("amount");
                    $m_expense = ExpenseModel::where('date', 'like', $month . '%')->where("admin_station", $station->id)->sum("amount");
                    $m_gross_profit = $m_income - $m_expense;

                    $y_income = AjoModel::where('date', 'like', $year . '%')->where("is_charge", true)->sum("amount");
                    $y_expense = ExpenseModel::where('date', 'like', $year . '%')->where("admin_station", $station->id)->sum("amount");
                    $y_gross_profit = $y_income - $y_expense;

                } else if ($station->username == 'LOAN') {
                    $m_income = LoanModel::where('disbursement_date', 'like', $month . '%')->where("status", "PAID")->where("loan_type", "DEBITOR")->sum("commission");

                    $m_expense = ExpenseModel::where('date', 'like', $month . '%')->where("admin_station", $station->id)->sum("amount");

                    $m_gross_profit = $m_income - $m_expense;

                    $y_income = LoanModel::where('disbursement_date', 'like', $year . '%')->where("status", "PAID")->where("loan_type", "DEBITOR")->sum("commission");

                    $y_expense = ExpenseModel::where('date', 'like', $year . '%')->where("admin_station", $station->id)->sum("amount");

                    $y_gross_profit = $y_income - $y_expense;

                } else if ($station->username == 'SERVICE ROOM') {
                    $m_income = RoomModel::where('checked_in', 'like', $month . '%')->sum("total_charge");

                    $m_expense = ExpenseModel::where('date', 'like', $month . '%')->where("admin_station", $station->id)->sum("amount");

                    $m_gross_profit = $m_income - $m_expense;

                    $y_income = RoomModel::where('checked_in', 'like', $year . '%')->sum("total_charge");

                    $y_expense = ExpenseModel::where('date', 'like', $year . '%')->where("admin_station", $station->id)->sum("amount");

                    $y_gross_profit = $y_income - $y_expense;

                } else {

                }

            }

            $data = [
                "station_id" => $station->id,
                "station_name" => $station->username,
                "monthly" => [
                    "income" => intval($m_income),
                    "expense" => intval($m_expense),
                    "gross_profit" => intval($m_gross_profit),
                ],
                "yearly" => [
                    "income" => intval($y_income),
                    "expense" => intval($y_expense),
                    "gross_profit" => intval($y_gross_profit),
                ],
            ];
            array_push($financial_summary, $data);
        }

        return $financial_summary;
    }

    public function getBreakdown(Request $request)
    {
        $date = $request->date;
        $expense = ExpenseModel::where('date', 'like', $request->date . '%')->where("admin_station", $request->station_id)->get();


        if (in_array($request->station, [7, 8, 9])) {

            if ($request->station == 7) {
                DB::table('ajo')
                    ->select(
                        DB::raw("SUBSTRING(date, 1, 10) AS day"),
                        DB::raw("amount AS profit"),
                        DB::raw("CONCAT('Commission from ', users.first_name, ' ', users.last_name, ' contribution') AS description")
                    )
                    ->whereIn(DB::raw("SUBSTRING(date, 1, 10)"), function ($query) use ($date) {
                        $query->select(DB::raw("DISTINCT SUBSTRING(date, 1, 10)"))
                            ->from('ajo')
                            ->where('date', 'like', $date . '%');
                    })
                    ->join('users', '=', 'ajo.user_id')
                    ->where('is_charge', '1')
                    ->orderBy('day', 'ASC')
                    ->get();


            } else if ($request->station == 8) {
                DB::table('loan')
                    ->select(
                        DB::raw("SUBSTRING(disbursement_date, 1, 10) AS day"),
                        DB::raw("commission AS profit"),
                        DB::raw("CONCAT('%', loan.rate, ' Commission from ', users.first_name, ' ', users.last_name, ' ₦', FORMAT(loan.amount), ' loan') AS description")
                    )
                    ->whereIn(DB::raw("SUBSTRING(disbursement_date, 1, 10)"), function ($query) use ($date) {
                        $query->select(DB::raw("DISTINCT SUBSTRING(disbursement_date, 1, 10)"))
                            ->from('loan')
                            ->where('disbursement_date', 'like', $date . '%');
                    })
                    ->join('users', '=', 'loan.user_id')
                    ->where('loan_type', 'DEBITOR')
                    ->orderBy('day', 'ASC')
                    ->get();
            } else if ($request->station == 9) {
                DB::table('service_room')
                    ->select(
                        DB::raw("SUBSTRING(checked_in, 1, 10) AS day"),
                        DB::raw("total_charge AS profit"),
                        DB::raw("CONCAT(service_room.duration, ' Day(s) service charge from ', users.first_name, ' ', users.last_name) AS description")
                    )
                    ->whereIn(DB::raw("SUBSTRING(checked_in, 1, 10)"), function ($query) use ($date) {
                        $query->select(DB::raw("DISTINCT SUBSTRING(checked_in, 1, 10)"))
                            ->from('service_room')
                            ->where('checked_in', 'like', $date . '%');
                    })
                    ->join('users', '=', 'service_room.user_id')
                    ->orderBy('day', 'ASC')
                    ->get();
            }
        } else {
            $transaction = DB::table('transaction_history')
                ->select(
                    DB::raw("SUBSTRING(transaction_time, 1, 10) AS day"),
                    DB::raw("SUM(profit) AS profit"),
                    DB::raw("CONCAT(COUNT(profit), ' Transaction(s) was performed') AS description")
                )
                ->whereIn(DB::raw("SUBSTRING(transaction_time, 1, 10)"), function ($query) use ($date) {
                    $query->select(DB::raw("DISTINCT SUBSTRING(transaction_time, 1, 10)"))
                        ->from('transaction_history')
                        ->where('transaction_time', 'like', $date . '%');
                })
                ->where('admin_station', $request->station_id)
                ->groupBy('day')
                ->orderBy('day', 'ASC')
                ->get();
        }

        return ['transaction' => $transaction, 'expense' => $expense];
    }
}
