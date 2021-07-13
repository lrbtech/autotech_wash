<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_packages', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->nullable();
            $table->string('package_name_english')->nullable();
            $table->string('package_name_arabic')->nullable();
            $table->string('price')->nullable();
            $table->string('service_ids')->nullable();
            $table->string('image')->nullable();
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
        Schema::dropIfExists('shop_packages');
    }
}
