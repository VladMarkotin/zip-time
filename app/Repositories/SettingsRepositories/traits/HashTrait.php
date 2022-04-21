<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 16.04.2022
 * Time: 15:01
 */
namespace App\Repositories\SettingsRepositories\traits;


use Illuminate\Support\Facades\DB;

trait HashTrait
{
   function getAllHashCodes(array $params)
   {
       $query = "SELECT * FROM saved_tasks WHERE user_id = {$params['id']}";
       $response = DB::select($query); //ok //array with arrays of hash codes

       return $response;
   }
} 