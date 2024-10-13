<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\Services\NotificationService;

class PushNotifications extends Command
{
    private $notificationService;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'push:notifications';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pushes notification to devices';

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
        $this->notificationService->reminder();
        $this->info('end');
        return 0;
    }
}
