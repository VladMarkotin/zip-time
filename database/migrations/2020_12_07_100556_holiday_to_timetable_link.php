<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class HolidayToTimetableLink extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Создаю связь между таблицей рассписаний и таблицей с отпусками
        Schema::table('holidays', function (Blueprint $table) {
            $table->integer('timetable_id');
            $table->foreign("timetable_id")->references("id")->on("timetables")->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('timetable_link', function (Blueprint $table) {

        });
    }
}
