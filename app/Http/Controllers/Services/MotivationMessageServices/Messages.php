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
					   'first_day' => [
						'Your first plan has been created! 
						This is just the first step on the path to success, but you are already ahead of
						others. Keep winning!'					   ],
					   'second_day' => [
						  'Second plan has been created! Remember, success requires persistence
					         and hard work.'
						],
					   'after_1_week' => [
						'You`ve using Quipl for 7 days. 
						 Yes, the period is not that long. However, the main thing is that
						 success is 7 days closer'
					   ],
					   'after_1_month' => [
						 'You`ve using Quipl for 30 days. It`s time to think about your effectiveness.
						  After the close of this day, look at the "statistics" section'
					   ],
					   'after_weekend' => [
						  'Glad to see you after the weekend. We hope you had a good rest and are ready for new achievements'
					    ],
					   'after_fail' => [
						  'The path to success is not always smooth. We are glad that despite your yesterday failure you returned.'
					   ],
					   'after_emergency' => [
						  'Welcome back! We hope the emergency mode helped you. And now it`s time to conquer the peaks again'
					   ],
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
