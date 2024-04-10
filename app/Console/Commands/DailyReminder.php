<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Repositories\DayPlanRepositories\CreateDayPlanRepository;

class DailyReminder extends Command
{
    private $dayPlan                   = null;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'daily:plan';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'daily plan reminder';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct( CreateDayPlanRepository $createDayPlanRepository)
    {
        $this->dayPlan = $createDayPlanRepository;
        parent::__construct();
      

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        return   $this->dayPlan->reminder();
    }
}
