<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
        \App\Console\Commands\ReminderCron::class,
        \App\Console\Commands\WeeklyProfitCron::class,
        \App\Console\Commands\TestCron::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();

        $schedule->command('test:notify')
            ->dailyAt('5:25');

        $schedule->command('weekly-profit:notify')
            ->dailyAt('5:30');

        // DAILY REPORT REMINDER
        $schedule->command('reminder:notify')
            ->dailyAt('19:00');

        // WEEKLY PROFIT NOTIFIER
        $schedule->command('weekly-profit:notify')
            ->weeklyOn(1, '9:00');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
