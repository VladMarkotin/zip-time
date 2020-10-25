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
                          \Illuminate\Support\Carbon $carbon) {
    if(Auth::check()){
        if(AuS::doTimeTableExist(\Illuminate\Support\Facades\Auth::id())) {
            $dayPlan = $planService->getDayPlan(AuS::doTimeTableExist(\Illuminate\Support\Facades\Auth::id()));
            $isEmergencyOn = AuS::isEmergencyOn(AuS::doTimeTableExist( \Illuminate\Support\Facades\Auth::id() ));
            if(!$isEmergencyOn){
                return view('home')->with(['plan' => $dayPlan,
                    'date' => \Illuminate\Support\Carbon::today()->toDateString(),
                    'day_status'   => $planService->getDayStatus(\Illuminate\Support\Facades\Auth::id()),
                    'final_estimation' => $planService->getFinalEstimation(\Illuminate\Support\Facades\Auth::id()),
                    'own_estimation'   => $planService->getOwnEstimation(\Illuminate\Support\Facades\Auth::id()),
                    'comment'      => $planService->getComment( \Illuminate\Support\Facades\Auth::id()),
                    'necessary'    => $planService->getNecessary( \Illuminate\Support\Facades\Auth::id()),
                    'for_tommorow' => $planService->getForTomorrow( \Illuminate\Support\Facades\Auth::id()),
                ]);
                //возвращаю вьюху с составленным планом
            }
            else{
                return view('emergency')->with(['plan' => $dayPlan,
                    'date' => \Illuminate\Support\Carbon::today()->toDateString(),
                    'day_status'   => $planService->getDayStatus(\Illuminate\Support\Facades\Auth::id()),
                    'final_estimation' => "",
                    'own_estimation'   => "",
                    'comment'      => $planService->getComment( \Illuminate\Support\Facades\Auth::id()),
                    'necessary'    => '',
                    'for_tommorow' => '',
                ]);
            }

        }
        else {
            AuS::isTimetableLegal(\Illuminate\Support\Facades\Auth::id());

            return view('welcome');
        }
    }
    return view('auth.login');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/hist', 'HistController@index')->name('hist');

Route::post('/add', 'PlanController@index');

Route::post('/estimate', 'PlanController@estimate');

Route::post('/addwork', 'PlanController@addWork');

Route::post('/emergency', 'PlanController@emergencyCall');

Route::post('/approve', 'PlanController@approve');
