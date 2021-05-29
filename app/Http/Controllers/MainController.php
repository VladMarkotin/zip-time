<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 29.05.2021
 * Time: 7:52
 */

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class MainController {

    public function addHashCode(Request $request){

        dd($request->input('hash'));
    }
} 