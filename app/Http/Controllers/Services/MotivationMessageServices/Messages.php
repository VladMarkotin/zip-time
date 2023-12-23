<?php
namespace App\Http\Controllers\Services\MotivationMessageServices;

class Messages 
{
    private static $messages = [
        'en' =>
	       [
				'greetings' => [
					'close_day' => [
					   'first_day' => 'Congratulations!..',
					   'second_day' => '',
					   'usual_day' => 'Your day plan has been completed :) Good work!',
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
				    'close_day' => 
                        [
							"You can`t close your day plan! Either some required jobs/tasks are incomplete
                                                           or you final mark lower then minimum
									(%)",
						],
                     'create_plan' => [
                        'message' => []
                     ],
				],
				'close_day' => [
                    'success' => [''],
				],
				'chg_user_status' => [
						''
				]
		   ]

    ];

    public static function getMessages()
    {
        return self::$messages;
    }
}
