<?php
namespace App\Http\Controllers\Services\MotivationMessageServices;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Services\MotivationMessageServices\Messages;


class MotivationMessageService
{
    /*private $messages = [
        'en' =>
	       [
				'greetings' => [
					'close_day' => [
					   'first_day' => 'Congratulations!..',
					   'second_day' => '',
					   'usual_day' => '',
					   'after_1_week' => '',
					   'after_1_month' => '',
					],
					'create_plan' => [
					   'usual_day' => [
						  'Plan has been successfully created! We wish you to realize conceived :)',
					   ],
					   'second_day' => [],
					   'after_1_week' => [],
					   'after_1_month' => [],
					   'after_weekend' => [],
					   'after_fail' => [],
					   'after_emergency' => [],
					],
					'estimate' => [
						'success' => [
							'Task has been updated.'
						],
						'error_undone'    => [
							'Error! Some required subtasks are still undone.'
						],
						'error' => [
							'Error during estimation',
						],
						'details' => 'In average, your mark for this job = ..%'
					],
					
				],
				'errors' => [
				    'close_day' => [
                        [
							'message' => ["You can`t close your day plan! Either some required jobs/tasks are incomplete
                                                           or you final mark lower then minimum
									(%)"],
						],
                     ],
                     'create_plan' => [
                        'message' => []
                     ],
                     'estimate' => [
                         'message' => []
                     ],
				],
				'info' => [
				
				],
				'chg_user_status' => [
						''
				]
		   ]

    ];*/
	private $messages = [];

    public function __construct()
    {}

    public function getMessage(array $data)
    {
		$this->messages = Messages::getMessages();
		$index = (isset($data['index'])) ? $data['index'] : 'usual_day'; //get index
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
				
				return $this->messages[$data['lang']][$data['type']]['close_day'][$ind-1];
		}
	}

	private function getRandIndex($arrLen)
	{
		$ind = (mt_rand(0, $arrLen) ) ?: 0;

		return (!$ind) ? 1 : $ind;
	}
}