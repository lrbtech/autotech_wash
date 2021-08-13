<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id')->nullable();
            $table->string('admin_id')->nullable();
            $table->string('message_from')->default('0');
            $table->TEXT('message')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('read_status')->default('0');
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
        Schema::dropIfExists('admin_customers');
    }
}
