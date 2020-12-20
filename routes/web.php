<?php

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
use Illuminate\Support\Facades\Route;
use Controllers\Services\AuthServices\AuthService as AuS;

Route::get('/', function (Controllers\Services\PlanServices\DisplayPlanService $planService,
                          \Illuminate\Support\Carbon $carbon,
                          Controllers\Services\AuthServices\AuthService $authService) {
    if(Auth::check()){
        $isVacationOn = $authService->isVacationOn(\Illuminate\Support\Facades\Auth::id());
        if(!$isVacationOn){ //Отпуск не активирован
            if(AuS::doTimeTableExist(\Illuminate\Support\Facades\Auth::id())) { //Создано ли расписание на день
                $dayPlan = $planService->getDayPlan(AuS::doTimeTableExist(\Illuminate\Support\Facades\Auth::id()));
                $isEmergencyOn = AuS::isEmergencyOn(AuS::doTimeTableExist( \Illuminate\Support\Facades\Auth::id() ));
                if(!$isEmergencyOn){ //взят ли экстренный режим

                    return view('home')->with(['plan' => $dayPlan,
                        'date' => \Illuminate\Support\Carbon::today()->toDateString(),
                        'day_time' =>  $planService->getDayTime(\Illuminate\Support\Facades\Auth::id()),
                        'day_status'   => $planService->getDayStatus(\Illuminate\Support\Facades\Auth::id()),
                        'final_estimation' => $planService->getFinalEstimation(\Illuminate\Support\Facades\Auth::id()),
                        'own_estimation'   => $planService->getOwnEstimation(\Illuminate\Support\Facades\Auth::id()),
                        'comment'      => $planService->getComment( \Illuminate\Support\Facades\Auth::id()),
                        'necessary'    => $planService->getNecessary( \Illuminate\Support\Facades\Auth::id()),
                        'for_tommorow' => $planService->getForTomorrow( \Illuminate\Support\Facades\Auth::id()),
                        'message'      => "У вас не составлен план на день! Исправить это можно здесь",
                    ]);
                    //возвращаю вьюху с составленным планом
                }
                else{
                    return view('emergency')->with(['plan' => $dayPlan,
                        'date' => \Illuminate\Support\Carbon::today()->toDateString(),
                        'day_time'         => "-",
                        'day_status'       => $planService->getDayStatus(\Illuminate\Support\Facades\Auth::id()),
                        'final_estimation' => "-",
                        'own_estimation'   => "-",
                        'comment'          => $planService->getComment( \Illuminate\Support\Facades\Auth::id()),
                        'necessary'        => '',
                        'for_tommorow'     => '',
                    ]);
                }

            }
            else {
                AuS::isTimetableLegal(\Illuminate\Support\Facades\Auth::id());
                $isWeekendAble  = $planService->isWeekendAble(\Illuminate\Support\Facades\Auth::id());
                $isVacationAble = $planService->isVacationAble(\Illuminate\Support\Facades\Auth::id());
                //dd($isVacationAble);
                return view('welcome')->with(['isWeekendAble' => $isWeekendAble, 'isVacationAble' => $isVacationAble]);
            }
        }else{
            return view('vacation.index');
        }
    }
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/hist', 'HistController@index')->name('hist');

Route::get('/hist/{i}', 'HistController@showDayPlanHist');

Route::get('/profile', 'ProfileController@index')->name('profile');

//Route::get('/stat', 'StatController@index')->name('stat'); Перестало работать ???
Route::get('/stat', 'StatController@period')->name('stat');

Route::get('/stat/period={i}', 'StatController@period');

Route::post('/add', 'PlanController@index');

Route::post('/estimate', 'PlanController@estimate');

Route::post('/addwork', 'PlanController@addWork');

Route::post('/emergency', 'PlanController@emergencyCall');

Route::post('/approve', 'PlanController@approve');

Route::post('/vacation', 'PlanController@setVacation');
