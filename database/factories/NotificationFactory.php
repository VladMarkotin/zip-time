<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Auth;

class NotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        // return [
        //     'user_id' => 1,
        //     'type' => $this->faker->word,
        //     'data' =>  $this->faker->text($maxNbChars = 60),
        //     'notification_date' => now(), // password
        //     'read_at' =>  $this->faker->randomElement([0, 1]),
        //     'broadcast_type' =>  $this->faker->randomElement(['public', 'private']),
        // ];
    }
}
