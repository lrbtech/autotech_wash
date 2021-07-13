<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('shop_id')->nullable();
            $table->string('customer_id')->nullable();
            $table->string('booking_id')->nullable();
            $table->string('payment_type')->default('0');
            $table->string('order_id')->nullable();
            $table->string('pay_url')->nullable();
            $table->string('payment_id')->nullable();
            $table->string('payment_status')->default('0');
            $table->string('booking_type')->default('0');
            $table->TEXT('booking_for')->nullable();
            $table->string('booking_date')->nullable();
            $table->string('booking_time')->nullable();
            $table->string('coupon_id')->default('0');
            $table->string('coupon_code')->nullable();
            $table->string('subtotal')->default('0');
            $table->string('coupon_value')->default('0');
            $table->string('total')->default('0');
            $table->string('otp')->nullable();
            $table->string('address_id')->default('0');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->TEXT('address')->nullable();
            $table->string('vehicle_id')->default('0');
            $table->string('booking_status')->default('0');
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
        Schema::dropIfExists('bookings');
    }
}
