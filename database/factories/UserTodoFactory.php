<?php

namespace Database\Factories;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserTodo>
 */
class UserTodoFactory extends Factory
{


    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition()
    {
        $usersIds = [];
        $todosIds = [];

        foreach(User::all() as $user)
            $usersIds [] = $user->id;
        foreach(Todo::all() as $todo)
            $todosIds [] = $todo->id;
        
        return [
            //
            'todo'=>$this->faker->unique()->randomElement($todosIds),
            'commander'=>$this->faker->randomElement($usersIds),
            'soldier'=>$this->faker->randomElement($usersIds)
        ];
    }
}
