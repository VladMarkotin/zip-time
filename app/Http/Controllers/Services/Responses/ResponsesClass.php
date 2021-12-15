<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 12.12.2021
 * Time: 15:15
 */
namespace App\Http\Controllers\Services\Responses;


class ResponsesClass
{
   private $responses = [
       "lang" => [
           "en" => [
               "states"   => [
                   "success" => [
                       "status" => "success",
                       "messages" => [],
                   ],
                   "fail"    => [],
               ],
           ]
       ]

   ];
} 