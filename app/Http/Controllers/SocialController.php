<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Models\DefaultConfigs;
use App\Models\PersonalConfigs;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite as Socialite;
//for assigning first challenge to new user
use App\Http\Controllers\Services\Challenges\RewardService;


class SocialController extends Controller
{
    public function index()
    {
        if (Auth::user()) {

            return view('welcome')->with('id', Auth::id());
        }

        return view('welcome');
    }

    public function redirect($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function Callback($provider)
    {
        $userSocial =   Socialite::driver($provider)->stateless()->user();
        $users       =   User::where(['provider_id' => $userSocial->getId()])->first();
        if ($users) {
            Auth::login($users);
            return redirect('/'); //->with('user', $users);
        } else {
            $user = User::create([
                'name'          => $userSocial->getName(),
                'email'         => $userSocial->getEmail(),
                'image'         => $userSocial->getAvatar(),
                'provider_id'   => $userSocial->getId(),
                'provider'      => $provider,
            ]);
            $this->createConfigs( $user );
            $currentUser       =   User::where(['provider_id' => $userSocial->getId()])->first();
            Auth::login($currentUser);

            return redirect('/');
        }
    }

    private function createConfigs($user)
    {

        $default_config = new DefaultConfigs;
        $personal_config = new PersonalConfigs;
        $def_config_data = [
            [
                'config_block_id' => 1,
                'config_data' => '{"groups":[{"to":499,"from":100},{"to":999,"from":500},{"to":1199,"from":1000},{"to":1399,"from":1200},{"to":1599,"from":1400},{"to":1799,"from":1600},{"to":1999,"from":1800},{"to":"inf","from":2000}]}',
            ],

            [
                'config_block_id' => 2,
                'config_data' =>
                '{"cardRules":[{"maxMark":"100","maxTime":"12:00","minMark":"10","minTime":"05:00","maxPlanTime":16,"maxPriority":"3","minPriority":"1","minFinalMark":"30","minRequiredTaskQuantity":"2"}]}',
            ],

            [
                'config_block_id' => 2,
                'config_data' =>
                '{"rules":[{"weekends":"1","minFinalMark":"30","minRequiredTaskQuantity":"2"}]}',
            ],
        ];

        $personal_config_data = [
            'user_id' => $user->id,
            'config_block_id' => 2,
            'config_data' => '{"rules":[{"weekends":"2","minFinalMark":"90","minRequiredTaskQuantity":"2"}]}',
            'last_updates' => '{"weekend_updated_at":"0:0:0"}'
        ];

        //collect($def_config_data)->map(function ($data) use ($default_config) { $default_config->create($data); });
        $personal_config->create($personal_config_data);
    }
}
