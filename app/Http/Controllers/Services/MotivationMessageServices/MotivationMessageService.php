<?php
namespace App\Http\Controllers\Services\MotivationMessageServices;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\MotivationMessageServices\Messages;
use App\Http\Controllers\Services\MotivationMessageServices\AnalizeUserDetailsService;


class MotivationMessageService
{
	private $analizeUserDetailsService = null;
	private $messages = [];

    public function __construct(AnalizeUserDetailsService $analizeUserDetailsService)
    {
		$this->analizeUserDetailsService = $analizeUserDetailsService;
	}

    public function getMessage(array $data)
    {
		$this->messages = Messages::getMessages();
		//Have to define get index` logic
		/**
		 * Have to understand user`s index
		 * need service to analize user`s details
		 */
		$index = $this->analizeUserDetailsService->analizeUserDetails($data);
		switch($data['state']) {
			case 'create_plan':
				$arrLen = count($this->messages[$data['lang']][$data['type']]['create_plan'][$index]);
				$ind = $this->getRandIndex($arrLen);
				
				return $this->messages[$data['lang']][$data['type']]['create_plan'][$index][$ind-1];
			case 'estimate': 
				$arrLen = count($this->messages[$data['lang']][$data['type']]['estimate'][$index]);
				$ind = $this->getRandIndex($arrLen);
				
				return $this->messages[$data['lang']][$data['type']]['estimate'][$index][$ind-1];
			case 'close_day':
				$arrLen = count($this->messages[$data['lang']][$data['type']]['close_day']);
				$ind = $this->getRandIndex($arrLen);
				
				return $this->messages[$data['lang']][$data['type']][$data['state']][$index];
		}
	}

	private function getRandIndex($arrLen)
	{
		$ind = (mt_rand(0, $arrLen) ) ?: 0;

		return (!$ind) ? 1 : $ind;
	}
}