<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRemindsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reminds', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('sphere id');
            $table->string('content');
            $table->dateTime('date');
            $table->char('repeat_term', 2)->default('oO');//#eD|eW|eM|eY|oO каждый день/неделя/месяц/год/единожды
            $table->timestamps();

            $table->foreign("user_id")->references("id")->on('users');
            $table->foreign("sphere_id")->references("id")->on('sphere');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reminds');
    }
}
