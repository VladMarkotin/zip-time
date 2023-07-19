<?php
namespace App\Http\Controllers\Services\PersonalResultServices;


use Carbon\Carbon;
use Auth;
use App\Models\User;

class PersonalResultsService 
{
    use \App\Http\Controllers\Services\PersonalResultServices\traits\UserAchievmentsTrait;

    private $configs = null;
    private $userRate = null;

    public function getResults($configs)
    {
        $this->configs = $configs;
        $this->userRate = $this->getCurrentRate(['user_id' => Auth::id()]);
        return $this->getData(['current_rate' =>  $this->userRate], $configs);
    }

    public function getCurrentRate(array $data)
    {
        return User::find($data['user_id'])->rating;
    }
}