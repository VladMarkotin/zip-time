<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTimetablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('timetables', function (Blueprint $table) {
            $table->id(); //id
            $table->unsignedBigInteger("user_id"); //связь с пользователем
            $table->date("date"); //дата плана
            $table->tinyInteger("day_status")->default(2); //Статус дня ("4-holiday(?)","3 - finished","2 - work","1 - weekend","0 - emergency", "-1 - Fine)
            $table->float("final_estimation"); //оценка за день
            $table->float("own_estimation"); //личная оценка за день
            $table->text("comment")->nullable(); //комментарий
            $table->text("necessary")->nullable(); //необходимо
            $table->text("for_tomorrow")->nullable(); //на завтра
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
        Schema::dropIfExists('timetables');
    }
}
