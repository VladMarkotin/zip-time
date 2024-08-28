<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DataDeletionPolicyController extends Controller
{
    public function index()
    {
        return view('dataDeletionPolicy');
    }
}
