<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLaravelTwilioMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laravel_twilio_messages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('type');
            $table->string('receiver');
            $table->string('sender');
            $table->string('text')->nullable();
            $table->string('mediaUrl')->nullable();
            $table->string('status')->nullable();
            $table->text('response')->nullable();
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
        Schema::dropIfExists('laravel_twilio_messages');
    }
}