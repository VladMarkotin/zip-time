<?php

namespace App\Console;

use App\Repositories\EstimationRepository;
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
        'App\Console\Commands\EstimateDayCommand',
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->call(function () {
        //     $repository = new EstimationRepository();
        //     $repository->estimate();
        // })
        //     ->timezone('Europe/Minsk')
        //     //->dailyAt("14:46")
        //     ->everyMinute()
        //     ->appendOutputTo(storage_path('logs/inspire.log'));


            $schedule->command('daily:plan') 
            ->timezone('Europe/Minsk')
            //->dailyAt("14:46")
             ->twiceDaily(10,22)
            ->appendOutputTo(storage_path('logs/inspire.log'));;
    }



    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
