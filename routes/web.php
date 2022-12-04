<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('welcome');
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/policy', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
/*Socialite ex https://medium.com/@Alabuja/social-login-in-laravel-with-socialite-90dbf14ee0ab*/

Route::get('login/{provider}', [App\Http\Controllers\SocialController::class, 'redirect']);
Route::get('login/{provider}/callback', [App\Http\Controllers\SocialController::class,'Callback']);

Route::middleware(['auth'])->group(function () {
    Route::post('/addPlan', [App\Http\Controllers\MainController::class, 'addPlan'] );
    Route::post('/addHashCode', [App\Http\Controllers\MainController::class, 'addHashCode']);//
    Route::post('/getSavedTasks', [App\Http\Controllers\MainController::class, 'getSavedTasks']);
    Route::post('/getSavedTask', [App\Http\Controllers\MainController::class, 'getSavedTaskByHashCode']);
    Route::post('/ifexists', [App\Http\Controllers\MainController::class, 'getCreatedPlanIfExists']);//check whether timetable exists
    Route::post('isWeekendAvailable',[App\Http\Controllers\MainController::class, 'isWeekendAvailable']);
    
    //get info about closed day
    Route::post('/getClosedPlanInfo', [App\Http\Controllers\MainController::class, 'getClosedDayInfo']);
    //estimate Task
    Route::post('/estimate', [App\Http\Controllers\MainController::class, 'estimateTask']);
    //Estimate day
    Route::post('/closeDay', [App\Http\Controllers\MainController::class, 'estimateDay']);

//Add job
    Route::post('/addJob', [App\Http\Controllers\MainController::class, 'addJob']);

    //History routes
    Route::prefix('hist')->group(function () {
        Route::get('/', [App\Http\Controllers\HistController::class, 'index']);
        Route::get('/{date}', [App\Http\Controllers\HistController::class, 'histOnDate']);
    });
    //end History routes

    //Statistics
    Route::prefix('stat')->group(function () {
        Route::get('/', [App\Http\Controllers\StatController::class, 'index']);
        Route::post('/', [App\Http\Controllers\StatController::class, 'getStatInfo']);
    });
    //end statistic

//emergency
    Route::post('/emergency', [App\Http\Controllers\EmergencyController::class, 'index']);
//settings
    Route::get('/settings',  [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/{setting}', [App\Http\Controllers\SettingsController::class, 'index']);
    //Backlog
    Route::get('backlog', [App\Http\Controllers\BackLogController::class, 'index'])->name('backlog');


});


Route::get('/event', function (){
    event(new \App\Events\MessageNotification('test broadcast'));
});

Route::get('/listen', function (){
    return view('listen');
});

Route::get('/markov-index', function (){
  return view('markov-index');
});
