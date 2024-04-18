<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\UsersChallenges;
use Illuminate\Support\Facades\Log;
use Auth;
use DB;

class ChallengeController extends Controller
{
    public function getUsersChallenges(Request $request)
    {
        $challenges = DB::select("SELECT c.id, c.title, c.terms, u_c.completeness, u_c.is_active FROM `challenges` c 
                                    JOIN user_challenges u_c ON c.id = u_c.challenge_id 
                                        WHERE u_c.user_id = ".Auth::id() ." ORDER BY u_c.created_at DESC"); //
        //Log::info('User registered', ['name' => $challenges]);
        $challenges3 = ['challenges' => $challenges]; //
        
        return response()->json(['challenges' => $challenges3],200, ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }
}
