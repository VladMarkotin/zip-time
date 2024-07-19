<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDefaultSavedTaskIdToSavedTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('saved_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('default_saved_task_id')->nullable()->after('user_id');
            $table->foreign('default_saved_task_id')
                  ->references('id')
                  ->on('default_saved_tasks')
                  ->onDelete('cascade');
            $table->index('default_saved_task_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('saved_tasks', function (Blueprint $table) {
            $table->dropForeign(['default_saved_task_id']);
            $table->dropIndex(['default_saved_task_id']);
            $table->dropColumn('default_saved_task_id');
        });
    }
}
