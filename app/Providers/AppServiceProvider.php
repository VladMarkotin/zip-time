<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;
use App\Http\Controllers\Services\Challenges\Contracts\ChallengeContract;
use App\Http\Controllers\Services\Challenges\CompleteNTasks;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //$this->app->singleton(ChallengeContract::class, CompleteNTasks::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        https://laravel.com/docs/8.x/responses#response-macros
        Response::macro('success_create_plan', function ($value) {
            return Response::make(strtoupper($value));
        });
    }
}
