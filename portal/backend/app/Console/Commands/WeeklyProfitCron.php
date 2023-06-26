<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\NotificationController;
use App\Model\AdminModel;
use App\Model\TransactionModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class WeeklyProfitCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weekly-profit:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This CRON notifies CEO on weekly profit.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        log::alert("WEEKLY PROFIT CRON ::::::::::::::::::::::::::");
        $deviceTokens = AdminModel::select('device_token', 'username')
            ->where('role', 'ADMIN')->whereNotIn('device_token', [null])
            ->get();

        $receiver = [];

        // Get the current date
        $currentDate = Carbon::now();

        // Calculate the date 7 days ago
        $sevenDaysAgo = $currentDate->subDays(7)->toDateString();

        // Retrieve records where the date is within the last 7 days
        //$profit = TransactionModel::where('transaction_time', '>=', $sevenDaysAgo)->where("admin_station", $request->admin_station)->sum("profit");
        $profit = TransactionModel::where('transaction_time', '>=', $sevenDaysAgo)->sum("profit");

        foreach ($deviceTokens as $user) {
            // $receiver[] = $token->device_token;
            NotificationController::createNotification("LAST WEEK PROFIT UPDATE", "Hi " . $user->username . " last week profit was ₦" . number_format($profit), [$user->device_token]);
        };
    }
}
