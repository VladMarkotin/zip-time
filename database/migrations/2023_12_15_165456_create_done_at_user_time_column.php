<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDoneAtUserTimeColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subplans', function (Blueprint $table) {
            $table->timestamp('done_at_user_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('subplans', function (Blueprint $table) {
            $table->dropColumn('done_at_user_time');
        });
    }
}
