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
         Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        Mail::raw('Text to e-mail', function ($message) {
            $message->from('nikolay.balkandzhiyski@gmail.com', 'Laravel');

            $message->to('nikolay.balkandzhiyski@gmail.com');
        })->everyMinute();
    }
}
