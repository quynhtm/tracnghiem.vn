<?php

namespace App\Console;

use App\Http\Commands\CronCacheClear;
use App\Http\Commands\CronCheckGroupDebtRepayment;
use App\Http\Commands\CronEncryptData;
use App\Http\Commands\CronSendNotificationMarketing;
use App\Http\Commands\CronChiaYCVChoDuyetCap1;
use App\Http\Commands\CronChiaYCVKheUoc;

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

        CronSendNotificationMarketing::class,
        CronCacheClear::class,

        CronChiaYCVChoDuyetCap1::class,
        CronChiaYCVKheUoc::class,

        CronCheckGroupDebtRepayment::class,#cronjob check nhom no | anhnt
        CronEncryptData::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
         $schedule->command('cronjob:CronSendNotificationMarketing',[WEEKENDS])->everyMinute()->weekends();
         $schedule->command('cronjob:CronSendNotificationMarketing',[WEEKDAYS])->everyMinute()->weekdays();
         $schedule->command('cronjob:CronSendNotificationMarketing',[EVERYDAY])->everyMinute()->twiceDaily(7,23);
         $schedule->command('cronjob:CronSendNotificationMarketing',[EVERYMONTH])->monthlyOn(1,'00:01');
         $schedule->command('cronjob:CronCacheClear')->quarterly();

         $schedule->command('cronjob:CronCheckGroupDebtRepayment')->everyFiveMinutes();#check nhóm nợ cập nhật hợp đồng vay || 14:46 anhnt4

         $schedule->command('cronjob:CronEncryptData')->everyFiveMinutes();

         //cronJob chia YCV
         //$schedule->command('cronjob:CronChiaYCVChoDuyetCap1')->everyFiveMinutes()->between('09:00', '16:00');//chia YCV chờ duyệt cấp 1
         //$schedule->command('cronjob:CronChiaYCVKheUoc')->everyFiveMinutes()->between('09:00', '16:00');//chia YCV khế ước
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
