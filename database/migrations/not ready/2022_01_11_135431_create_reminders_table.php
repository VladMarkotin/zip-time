<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("user_id");//связь с юзером
            $table->boolean('is_active')->default(true);//активно ли напоминание?Должен ли сервер его учитывать
            $table->boolean('is_watched')->default(false);//???
            $table->string("name");//заголовок напоминания
            $table->string("details");//описание и детали
            $table->date("date"); //дата на которую выставлено напоминание
            $table->time("time"); //время на которое выставлено напоминание
            $table->string("repeat")->default('o');//каждый y-год m-месяц w-неделю d-день o-только раз
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reminders');
    }
}
