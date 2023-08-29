<?php
namespace App\Http\Controllers\Services\Configs;


use App\Models\DefaultConfigs;

class DefaultConfigs
{
    private $defaultConfigs = null;

    public function __construct(DefaultConfigs $defaultConfigs)
    {
        $this->defaultConfigs = $defaultConfigs;
    }

    //$defaultConfigs->cardRules[0]->maxMark
    public function getOption( $data)
    {
        $defaultConfig = json_decode(DefaultConfigs::select('config_data')->where('config_block_id', $data['config_block_id'])->get()->toArray()[0]['config_data']);
        die(var_dump($defaultConfig));
    }
}