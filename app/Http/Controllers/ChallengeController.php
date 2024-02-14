<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\UsersChallenges;
use Illuminate\Support\Facades\Log;
use Auth;

class ChallengeController extends Controller
{
    public function getUsersChallenges(Request $request)
    {
        $challenges = json_encode(['completness' => 72] );
        $challenges2 = UsersChallenges::where([['user_id', Auth::id()]]) // ['challenge_id', 1]
        ->get()
        ->toArray();
        Log::info('User registered', ['name' => $challenges2]);
        //$challenges3 = json_encode( ['completness' => $challenges2[0]['completeness']] ); //
        $challenges3 = json_encode( ['challenges' => $challenges2] ); //
        die($challenges3);
    }
}
