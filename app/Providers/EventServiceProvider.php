<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\FinishDayEvent;
use App\Events\CompleteTaskEvent;
use App\Listeners\CompleteTaskListener;
use App\Events\RewardEvent;
use App\Listeners\RewardListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        FinishDayEvent::class => [
            \App\Listeners\FinishDayListener::class,
        ],
        CompleteTaskEvent::class => [
            CompleteTaskListener::class
        ],
        RewardEvent::class => [
            RewardListener::class
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {}
}
