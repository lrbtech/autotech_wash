<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_products', function (Blueprint $table) {
            $table->id();
            $table->string('shop_id')->nullable();
            $table->string('product_name_english')->nullable();
            $table->string('product_name_arabic')->nullable();
            $table->string('price')->nullable();
            $table->string('image')->nullable();
            $table->TEXT('deny_remark')->nullable();
            $table->string('read_status')->default('0');
            $table->string('admin_status')->default('0');
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
        Schema::dropIfExists('shop_products');
    }
}
