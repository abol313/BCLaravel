<?php

namespace Database\Seeders;

use App\Models\UserTodo;
use App\Models\Todo;
use Illuminate\Database\Seeder;

class UserTodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach(Todo::all() as $todo)
            if(!$todo->hasRelationToUsers())
                UserTodo::factory(1)->createOne(['todo'=>$todo->id]);
    }
}
