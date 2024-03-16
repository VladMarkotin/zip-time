<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChallengesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('challenges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();//*На будущее* кто создал челлендж.Челленджи по умолчанию null
            $table->string('title');
            $table->char('index', 20); //для того, чтобы быстро взять нужный challenge
            $table->json('terms'); //правила челленджа
            $table->integer('for_rating')->nullable()->default(null); //челлендж для тех у кого рейтинг >= чем указанный
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
        Schema::dropIfExists('challenges');
    }
}
