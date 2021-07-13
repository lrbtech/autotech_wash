<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePushNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('push_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->nullable();
            $table->string('title')->nullable();
            $table->string('description')->nullable();
            $table->string('send_to')->nullable();
            $table->string('customer_ids')->nullable();
            $table->string('shop_ids')->nullable();
            $table->string('expiry_date')->nullable();
            $table->string('other_status')->nullable();
            $table->string('deny_remark',5000)->nullable();
            $table->string('status')->default('0');
            $table->string('read_status')->default('0');
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
        Schema::dropIfExists('push_notifications');
    }
}
