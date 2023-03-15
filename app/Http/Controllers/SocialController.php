<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite as Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class SocialController extends Controller
{
    public function index()
    {
        if(Auth::user()){

            return view('welcome')->with('id', Auth::id());
        }

        return view('welcome');
    }

    private function setTimeZone()
    {
        $ip = file_get_contents("http://ipecho.net/plain");
        $url = 'http://ip-api.com/json/'.$ip;    
        $info = file_get_contents($url);       
        $timezone = json_decode($info,true)['timezone'];        
        return  $timezone;  
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider){

       // dd($this->setTimeZone());
      
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $users       =   User::where(['email' => $userSocial->getEmail()])->first();
        if($users){
            Auth::login($users);
            //dd($users);
            return redirect('/');//->with('user', $users);
        }else{
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'image'         => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
                'timezone'      => $this->setTimeZone(),
            ]);
            return redirect('/');
        }
    }
}