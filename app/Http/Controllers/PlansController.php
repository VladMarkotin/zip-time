<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 08.01.2021
 * Time: 8:26
 */

namespace App\Http\Controllers;


class PlansController extends Controller
{
    public function __construct()
    {}

    public function index()
    {
        return view('plans.index');
    }
} 