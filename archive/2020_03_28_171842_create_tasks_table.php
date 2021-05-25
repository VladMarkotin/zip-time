<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list', function (Blueprint $table) {
            $table->integer('task_id')->autoIncrement();
            $table->integer("timetable_id"); //id расписания,которому принадлежит это задание
            $table->string("task_name");
            $table->text("details")->nullable(); //детали
            $table->string("time"); //примерное время
            $table->float("mark");
            $table->string("note"); //заметки
            $table->timestamps();

            $table->foreign("timetable_id")->references("id")->on('timetables');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list');
    }
}
