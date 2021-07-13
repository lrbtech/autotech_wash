<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAgentPasswordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('agent_passwords', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('agent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('busisness_name')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default('0');
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
        Schema::dropIfExists('agent_passwords');
    }
}
