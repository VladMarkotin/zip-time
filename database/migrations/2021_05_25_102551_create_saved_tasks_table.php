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
            $table->char('hash_code',6); //хеш-код состоит из #..... Должен быть уникален в пределах пользователя
            $table->unsignedBigInteger("user_id"); //связь с пользователем

            $table->string("task_name");
            $table->tinyInteger('type')->default(4); //тип задания: 4 - обязательное задание,3-необязательное задание, 2-обязательная задача, 1 - задача,0-напоминание
            $table->tinyInteger('priority')->default(0);//0-без приоритета,1-приоритет,2-двойной приоритет,3-тройной
            $table->text("details")->nullable(); //детали
            $table->string("time"); //примерное время
            $table->string("note"); //заметки
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');;
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
