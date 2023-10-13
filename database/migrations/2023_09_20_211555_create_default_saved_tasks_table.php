<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDefaultSavedTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('default_saved_tasks', function (Blueprint $table) {
            $table->id();
            $table->char('hash_code',12)->unique(); //общий хеш-код должен начинаться с #q-..... Должен быть уникальным в пределах таблицы!

            $table->string("task_name")->nullable();
            $table->tinyInteger('type')->nullable()->default(4); //тип задания: 4 - обязательное задание,3-необязательное задание, 2-обязательная задача, 1 - задача,0-напоминание
            $table->tinyInteger('priority')->default(0);//0-без приоритета,1-приоритет,2-двойной приоритет,3-тройной
            $table->text("details")->nullable(); //детали
            $table->string("time")->nullable(); //примерное время
            $table->string("note")->nullable(); //заметки
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('default_saved_tasks');
    }
}
