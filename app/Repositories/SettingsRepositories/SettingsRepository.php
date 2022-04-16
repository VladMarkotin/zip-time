<?php
/**
 * Created by PhpStorm.
 * User: Vlad
 * Date: 16.04.2022
 * Time: 14:51
 */
namespace App\Repositories\SettingsRepositories;


use App\Repositories\SettingsRepositories\traits\HashTrait;

class SettingsRepository
{
    private $settings = [
        "hash",
        "stat",
    ];

    //$params array should include 'id', 'option'
    public function getCurrentSettings(array $params)
    {
        switch($params['option']['setting']){
            case 'hash':
                return HashTrait::getAllHashCodes($params);
            case 'stat':
                break;
            default:
                return HashTrait::getAllHashCodes($params);
        }
    }
} 