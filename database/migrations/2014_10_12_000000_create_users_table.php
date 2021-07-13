<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('date')->nullable();
            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->string('service_ids')->nullable();
            $table->string('other_service')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('username')->nullable();
            $table->string('password')->nullable();
            $table->string('busisness_name')->nullable();
            $table->string('busisness_id')->nullable();
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->string('address',5000)->nullable();
            $table->string('nationality')->nullable();
            $table->string('country_id')->nullable();
            $table->string('emirates_id')->nullable();
            $table->string('trade_license_no')->nullable();
            $table->string('vat_certificate_no')->nullable();
            $table->string('passport_number')->nullable();
            $table->string('cover_image')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('trade_license')->nullable();
            $table->string('passport_copy')->nullable();
            $table->string('emirated_id_copy')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->TEXT('signature_data')->nullable();
            $table->string('login_status')->default('0');
            $table->string('status')->default('0');
            $table->string('user_id')->default('0');
            $table->string('role_id')->default('0');
            $table->string('account_number')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('iban_number')->nullable();
            $table->string('swift_code')->nullable();
            $table->string('account_name')->nullable();
            $table->string('firebase_key')->nullable();
            $table->TEXT('about_us_english')->nullable();
            $table->TEXT('about_us_arabic')->nullable();
            $table->string('otp')->nullable();
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
        Schema::dropIfExists('users');
    }
}
