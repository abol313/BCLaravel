<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            //
            'title'=>$this->faker->realTextBetween(5,12),
            'description'=>$this->faker->realTextBetween(20,300),
            'status'=>$this->faker->randomElement(['waiting','accepted','declined','done']),
            'due'=>$this->faker->dateTimeBetween('now','+1 year')
        ];
    }

}
