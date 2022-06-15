<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_todos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('todo')->unsigned();
            $table->foreign('todo')->references('id')->on('todos');

            $table->bigInteger('commander')->unsigned()->foreign_key_constraints;
            $table->foreign('commander')->references('id')->on('users');

            $table->bigInteger('soldier')->unsigned();
            $table->foreign('soldier')->references('id')->on('users');

            $table->timestamps();
            // $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_todos');
    }
};
