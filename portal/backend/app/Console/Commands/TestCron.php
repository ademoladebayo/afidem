<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Http\Controllers\NotificationController;
use App\Model\AdminModel;
use App\Model\TransactionModel;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This is a test CRON.';

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
        log::alert("TEST CRON ::::::::::::::::::::::::::");
        $deviceTokens = AdminModel::select('device_token', 'username')
            ->whereNotNull('device_token')
            ->get();


        foreach ($deviceTokens as $user) {
            // $receiver[] = $token->device_token;
            NotificationController::createNotification("NEW DAY MOTIVATION", "Hi " . $user->username . " Keep pushing hustle go pay !", [$user->device_token]);
        };
    }
}
