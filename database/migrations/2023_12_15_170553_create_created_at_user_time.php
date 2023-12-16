<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreatedAtUserTime extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('subplans', function (Blueprint $table) {
            $table->timestamp('created_at_user_time')->nullable()->after('updated_at');
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
            $table->dropColumn('created_at_user_time');
        });
    }
}
