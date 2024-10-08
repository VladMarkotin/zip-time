<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Types\StringType;
use Doctrine\DBAL\Types\Type;

class FixHashCodeInDefaultSavedTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {   
        if (!Type::hasType('char')) {
            Type::addType('char', StringType::class);
        }
        Schema::table('default_saved_tasks', function (Blueprint $table) {
            $table->dropUnique('default_saved_tasks_hash_code_unique');
            $table->char('hash_code',6)->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {   
        if (!Type::hasType('char')) {
            Type::addType('char', StringType::class);
        }
        Schema::table('default_saved_tasks', function (Blueprint $table) {
            $table->dropUnique('default_saved_tasks_hash_code_unique');
            $table->char('hash_code',12)->unique()->change();
        });
    }
}
