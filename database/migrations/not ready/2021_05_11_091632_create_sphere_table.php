<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSphereTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sphere', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->default(null);// все же в теории возможно что у юзера будет своя персональная сфера
            $table->string('name');
            $table->char('short_name', 10);//короткое название
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
        Schema::dropIfExists('sphere');
    }
}
