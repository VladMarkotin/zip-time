<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsFailedColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subplans', function (Blueprint $table) {
            $table->tinyInteger('is_failed')->unsigned()->default(0)->after('is_ready');
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
            $table->dropColumn('is_failed');
        });
    }
}
