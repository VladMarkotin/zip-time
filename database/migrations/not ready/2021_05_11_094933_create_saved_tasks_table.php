<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSavedTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('saved_tasks', function (Blueprint $table) {
            $table->id();
            $table->integer('sphere_id');
            $table->integer('user_id');
            $table->char('hash_code', 7);
            $table->string('name');
            $table->time('time');
            $table->tinyInteger('type')->default(1);//тип сохраненной сущности:0)задача 1)задание
            $table->timestamps();

            $table->foreign("sphere_id")->references("id")->on('sphere');
            $table->foreign("user_id")->references("id")->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('saved_tasks');
    }
}
