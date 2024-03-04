<?php
namespace App\Http\Controllers\Services\Configs;


use App\Models\DefaultConfigs as DF;

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
        $defaultConfig = json_decode(DF::select('config_data')->where('config_block_id', $data['config_block_id'])->get()->toArray()[0]['config_data']);
        die(var_dump($defaultConfig));
    }

    public static function getOptionViaIndex($index)
    {
        $defaultConfig = json_decode(DF::select('config_data')->where('config_block_id', 2)->get()->toArray()[0]['config_data']);
        
        return $defaultConfig->cardRules[0]->$index;
    }
}