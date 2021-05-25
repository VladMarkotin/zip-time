<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProblemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('problems', function (Blueprint $table) {
            $table->integer('problem_id')->autoIncrement();
            $table->integer("timetable_id");
            $table->string("problem_name");
            $table->boolean("priority")->default(false);
            $table->boolean("isPerfomed");
            $table->timestamps();

            $table->foreign("timetable_id")->references("id")->on("timetables");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('problems');
    }
}
