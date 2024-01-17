<?php
namespace App\Http\Controllers\Services\Challenges\Contracts;


interface ChallengeContract
{
    /**
     * Wrapper for excecuting challenge
     */
    function doChallenge(array $data);

     function countIndex($data);

     function getCompletnesPercent($data);

     function checkRules(array $rules);
}