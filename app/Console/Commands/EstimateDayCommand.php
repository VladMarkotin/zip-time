<?php

namespace App\Console\Commands;

use Illuminate\Support\Carbon;
use Illuminate\Console\Command;
use App\Repositories\EstimationRepository;

class EstimateDayCommand extends Command
{
    private $estimateDayRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'estimate:day';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'close day automatically';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(EstimationRepository  $estimationRepository)
    {
        parent::__construct();
        $this->estimateDayRepository  = $estimationRepository;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $this->info('start');
        $this->estimateDayRepository->estimate();
        $this->info('success');

        return 0;
    }
}
