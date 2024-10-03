<?php

namespace App\Console\Commands;

use App\Http\Controllers\Services\NotificationService;
use Illuminate\Console\Command;

class DailyReminder extends Command
{

    private NotificationService $notificationService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:name';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(NotificationService $notificationService)
    {
        parent::__construct();
        $this->notificationService  = $notificationService;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('start');
        $this->notificationService->dailyReminder();
        $this->info('end');
        return 0;
    }
}
