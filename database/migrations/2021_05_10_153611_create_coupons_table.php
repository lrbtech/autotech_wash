<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->nullable();
            $table->string('coupon_code');
            $table->string('description')->nullable();
            $table->string('start_date')->nullable();
            $table->string('end_date')->nullable();
            $table->string('discount_type')->nullable();
            $table->string('service_type')->nullable();
            $table->string('service_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('minimum_order_value')->nullable();
            $table->string('max_value')->nullable();
            $table->string('limit_per_user')->nullable();
            $table->string('limit_per_coupon')->nullable();
            $table->string('user_type')->nullable();
            $table->string('user_id')->nullable();
            $table->string('status')->nullable();
            $table->string('deny_remark',5000)->nullable();
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
        Schema::dropIfExists('coupons');
    }
}
