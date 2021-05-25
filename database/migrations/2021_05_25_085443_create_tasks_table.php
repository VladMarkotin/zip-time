<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("timetable_id"); //id расписания,которому принадлежит это задание
            $table->char('hash_code',6)->nullable(); //хеш-код состоит из #.....
            $table->string("task_name");
            $table->tinyInteger('type')->default(4); //тип задания: 4 - обязательное задание,3-необязательное задание, 2-обязательная задача, 1 - задача,0-напоминание
            $table->tinyInteger('priority')->default(0);//0-без приоритета,1-приоритет,2-двойной приоритет,3-тройной
            $table->text("details")->nullable(); //детали
            $table->string("time"); //примерное время
            $table->float("mark"); //оценка
            $table->string("note"); //заметки
            $table->timestamps();

            $table->foreign("timetable_id")->references("id")->on('timetables')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
