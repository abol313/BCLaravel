<?php

namespace Database\Seeders;

use App\Models\Todo;
use App\Models\User;
use App\Models\UserTodo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Todo::factory(4)->create();
    }
}
