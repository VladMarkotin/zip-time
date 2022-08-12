<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Backlog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('backlog', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id"); //связь с пользователем
            $table->unsignedBigInteger('saved_task_id')->nullable();
            $table->string('title');
            $table->text('content')->nullable();
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
            $table->foreign("saved_task_id")->references("id")->on('saved_tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
