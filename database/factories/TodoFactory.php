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
            'title'=>$this->faker->title(),
            'description'=>$this->faker->text(),
            'status'=>$this->faker->randomElement(['waiting','accepted','declined','done']),
            'due'=>$this->faker->dateTimeThisYear()
        ];
    }

}
