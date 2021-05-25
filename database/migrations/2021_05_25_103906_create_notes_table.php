<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Здес будет цепочка заметок к сохраненым заданиям */
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('saved_task_id'); //Связь с сохраненным заданием
            $table->string('note');
            $table->timestamps();

            $table->foreign("saved_task_id")->references("id")->on('saved_tasks')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
    }
}
