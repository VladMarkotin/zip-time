<?php
namespace App\Http\Controllers\Services\GPTService\traits;


trait transformGptResponseTrait
{
    public function transformData($data)
    {
        
        $response = explode('-' , $data);
        $result = array();
        foreach($response as $item)
        {
            if(strlen($item) > 0)
            {
               array_push($result, $item);
            }
        }
        return($result );
    }
}