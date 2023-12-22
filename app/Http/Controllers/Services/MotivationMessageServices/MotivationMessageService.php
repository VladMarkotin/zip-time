<?php
namespace App\Http\Controllers\Services\MotivationMessageServices;


use Illuminate\Support\Facades\Auth;

class MotivationMessageService
{
    private $messages = [
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
					   'usual_day' => '',
					   'second_day' => '',
					   'after_1_week' => '',
					   'after_1_month' => '',
					   'after_weekend' => '',
					   'after_fail' => '',
					   'after_emergency' => '',
					],
					'estimate' => [
						'success' => '',
						'fail' => '',
						'details' => 'In average, your mark for this job = ..%'
					],
					
				],
				'errors' => [
				    'close_day' => [
                        'message' => 'Error!..',
                     ],
                     'create_plan' => [
                        'message' => ''
                     ],
                     'estimate' => [
                         'message' => ''
                     ],
				],
				'info' => [
				
				],
				'chg_user_status' => [
						''
				]
		   ]

    ];

    public function __construct()
    {}

    public function getState(array $data)
    {}
}