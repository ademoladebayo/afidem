<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\NotificationController;
use App\Model\AdminModel;

class ReminderCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reminder:notify';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This CRON reminder terminal admin to upload daily report';

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
        $deviceTokens = AdminModel::select('device_token', 'username')
            ->where('role', 'ADMIN')
            ->get();

        $receiver = [];

        foreach ($deviceTokens as $user) {
            // $receiver[] = $token->device_token;
            NotificationController::createNotification("REMINDER !!!", "Hi " . $user->username . " do not forget to upload your report for today. ", $user->device_token);
        };
    }
}
