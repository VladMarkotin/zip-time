<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
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

Route::post('/addPlan', [App\Http\Controllers\MainController::class, 'addPlan'] )->middleware('auth');
Route::post('/addHashCode', [App\Http\Controllers\MainController::class, 'addHashCode'])->middleware('auth');//
Route::post('/getSavedTasks', [App\Http\Controllers\MainController::class, 'getSavedTasks'])->middleware('auth');
Route::post('/getSavedTask', [App\Http\Controllers\MainController::class, 'getSavedTaskByHashCode'])->middleware('auth');
Route::post('/ifexists', [App\Http\Controllers\MainController::class, 'getCreatedPlanIfExists'])->middleware('auth');//check whether timetable exists

Route::post('/estimate', [App\Http\Controllers\MainController::class, 'estimateTask'])->middleware('auth');
Route::post('/closeDay', [App\Http\Controllers\MainController::class, 'estimateDay'])->middleware('auth');

//History
Route::get('/hist', [App\Http\Controllers\HistController::class, 'index'])->middleware('auth');

//emergency
Route::post('/emergency', [App\Http\Controllers\EmergencyController::class, 'index'])->middleware('auth');