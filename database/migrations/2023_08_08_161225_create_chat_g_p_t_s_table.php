<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatGPTSTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gpt', function (Blueprint $table) {
            $table->id();          
            $table->string('openai_api_secret')->nullable();
            $table->string('openai_model')->default('gpt-3.5-turbo');
            $table->decimal('oai_temp', 2,1)->default(0.5);
            $table->unsignedBigInteger('oai_tokens')->default(1000);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_g_p_t_s');
    }
}
