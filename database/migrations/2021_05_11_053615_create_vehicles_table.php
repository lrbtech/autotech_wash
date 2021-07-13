<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('user_id')->nullable();
            $table->string('vehicle_name')->nullable();
            $table->string('brand')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('colour')->nullable();
            $table->string('registration_city')->nullable();
            $table->string('registration_code')->nullable();
            $table->string('registration_number')->nullable();
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
        Schema::dropIfExists('vehicles');
    }
}
