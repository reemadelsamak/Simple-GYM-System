<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\TrainingSession;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AttendanceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

            return [
                'user_id'=>$this->faker->randomElement(User::all())['id'],
                'training_session_id'=>$this->faker->randomElement(TrainingSession::all())['id'],
            ];

    }
}
