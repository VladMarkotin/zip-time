<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubplansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subplans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('saved_task_id')->nullable(); //ссылка на сохраненное задание, для которого сделан подплан
            $table->unsignedBigInteger('main_task_id')->nullable(); //на будущее
            $table->string('title');
            $table->text('text')->nullable();
            $table->integer('position')->default(1); //чем больше, тем задача должна быть выполнена раньше
            $table->tinyInteger('weight')->default(1); //вес задачи, для автоматического расчета оценки за все задание 
            $table->boolean('checkpoint')->default(false); //Является ли задача обязательной 
            $table->boolean('is_ready')->default(false);
            $table->timestamps();

            $table->foreign("task_id")->references("id")->on('tasks')->onDelete('cascade');
            $table->foreign("saved_task_id")->references("id")->on('saved_tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subplans');
    }
}
