<?php

namespace App\Http\Controllers;


use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Services\SettingsService;

class SettingsController extends Controller
{
    private $settingsService = null;

    public function __construct(SettingsService $settingsService)
    {
        $this->settingsService = $settingsService;
    }

    public function index(Request $request)
    {

        return view('settings');
        /*$setting = ($request->route()->parameters());
        $params = ['id' => Auth::id()];
        $response = null;
        if($setting) {
            $params['option'] = $setting;
            $response = $this->settingsService->getAllSettings($params);
        }

        return json_encode($response, JSON_UNESCAPED_UNICODE);*/
    }
}
