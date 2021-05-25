<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TimetableTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->integer('id')->autoIncrement(); //id
            $table->integer("user_id");
            $table->date("date"); //дата плана
            $table->string("day_status"); //Статус дня ("ред","утв","вых","экстренн")
            $table->float("final_estimation"); //оценка за день
            $table->float("own_estimation"); //личная оценка за день
            $table->text("comment")->nullable(); //комментарий
            $table->text("necessary")->nullable(); //необходимо
            $table->text("for_tommorow")->nullable(); //на завтра
            $table->timestamps();

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
        //
    }
}
