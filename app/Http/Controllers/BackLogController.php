<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BackLogController extends Controller
{
    public function index()
    {
        return view('backlog');
    }
}
