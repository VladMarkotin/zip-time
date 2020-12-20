<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 20.12.2020
 * Time: 7:51
 */

namespace App\Http\Controllers;


class ProfileController {

    public function index()
    {
        return view('profile.index');
    }
} 