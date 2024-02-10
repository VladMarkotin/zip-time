<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    public function getUsersChallenges(Request $request)
    {
        $challenges = json_encode(['completness' => 92] );
        die($challenges);
    }
}
