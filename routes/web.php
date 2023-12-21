<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\DefaultConfigs;
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
 
 
    Route::get('/notifications',      [App\Http\Controllers\NotificationController::class, 'notificationsHistory']);
                      
    Route::post('/addPlan', [App\Http\Controllers\MainController::class, 'addPlan'] );
    Route::post('/addHashCode', [App\Http\Controllers\MainController::class, 'addHashCode']);//
    Route::post('/getSavedTasks', [App\Http\Controllers\MainController::class, 'getSavedTasks']);
    Route::post('/getDefaultSavedTasks', [App\Http\Controllers\MainController::class, 'getDefaultSavedTasks']);
    Route::post('/getSavedTask', [App\Http\Controllers\MainController::class, 'getSavedTaskByHashCode']);
    Route::post('/getPreparedPlan', [App\Http\Controllers\MainController::class, 'getPreparedPlan']);//check whether we got prepared plan
    Route::post('/ifexists', [App\Http\Controllers\MainController::class, 'getCreatedPlanIfExists']);//check whether timetable exists
    Route::post('isWeekendAvailable',[App\Http\Controllers\MainController::class, 'isWeekendAvailable']);
    Route::post('/getEduStep', [App\Http\Controllers\MainController::class, 'getEduStep']);
    Route::post('/updateEduStep', [App\Http\Controllers\MainController::class, 'updateEduStep']);
    //get info about closed day
    Route::post('/getClosedPlanInfo', [App\Http\Controllers\MainController::class, 'getClosedDayInfo']);
    //estimate Task
    Route::post('/estimate', [App\Http\Controllers\MainController::class, 'estimateTask']);
    //Estimate day
    Route::post('/closeDay', [App\Http\Controllers\MainController::class, 'estimateDay']);

//Add job
    Route::post('/addJob', [App\Http\Controllers\MainController::class, 'addJob']);
    //user`s results
    Route::post('/get-results', [App\Http\Controllers\MainController::class, 'getUserResults']);

    //History routes
    Route::prefix('hist')->group(function () {
        Route::get('/', [App\Http\Controllers\HistController::class, 'displayHist'])->name('hist');
        Route::get('/{date}', [App\Http\Controllers\HistController::class, 'histOnDate']);
        Route::post('/', [App\Http\Controllers\HistController::class, 'index']);
    });
    //end History routes

    //Statistics
    Route::prefix('stat')->group(function () {
        Route::get('/', [App\Http\Controllers\StatController::class, 'index'])->name('stat');
        Route::post('/', [App\Http\Controllers\StatController::class, 'getStatInfo']);
    });

    //Edit card
    Route::post('/edit-card', [App\Http\Controllers\EditController::class, 'editCard'])->name('edit-card');
    //end edit card

    Route::get('/get-stat-data', [App\Http\Controllers\StatController::class, 'getStatData'])->name('get-stat-data');
    //end statistic

//emergency
    Route::post('/emergency', [App\Http\Controllers\EmergencyController::class, 'index']);
//
//settings
    Route::get('/settings',  [App\Http\Controllers\SettingsController::class, 'index'])->name('settings');
    Route::get('/settings/{setting}', [App\Http\Controllers\SettingsController::class, 'index']);
    //Backlog
    Route::get('backlog', [App\Http\Controllers\BackLogController::class, 'index'])->name('backlog');

    //getting notes for concrete task
    Route::post('/get-saved-notes', [App\Http\Controllers\NoteController::class, 'getSavedNotes'])->name('getSavedNotes');

    //Upgrade details in functionality in plan
    Route::post('/add-sub-task', [App\Http\Controllers\SubPlanController::class, 'createSubPlan'])->name('addSubTask'); //
    Route::post('/get-sub-tasks', [App\Http\Controllers\SubPlanController::class, 'getSubPlan'])->name('get-sub-tasks');//del-sub-task
    Route::post('/del-sub-task', [App\Http\Controllers\SubPlanController::class, 'delSubTask'])->name('get-sub-tasks');//
    Route::post('/complete-sub-task', [App\Http\Controllers\SubPlanController::class, 'completeSubTask'])->name('complete-sub-task');//
    Route::post('/edit-subtask', [App\Http\Controllers\SubPlanController::class, 'editSubTask'])->name('edit-sub-task');
    
    //Upgrade notes functionality
    Route::post('get-today-note-amount',[App\Http\Controllers\NoteController::class, 'getTodayNoteAmount'])->name('get-note-amount');
    
    //Local chatGPT functionality
    Route::post('/create-gpt-subplan-request', [App\Http\Controllers\SubPlanGPTController::class, 'makeRequestToGPT'])->name('create-gpt-subplan-request');
    Route::post('/create-gpt-subplan', [App\Http\Controllers\SubPlanGPTController::class, 'createSubPlanViaGPT'])->name('create-gpt-sub-task');


});
Route::post('/get-default-configs', function (){
    exit(DefaultConfigs::getConfigs());
});

Route::get('/event', function (){
    event(new \App\Events\MessageNotification('test broadcast'));
});

Route::get('/listen', function (){
    return view('listen');
});
 