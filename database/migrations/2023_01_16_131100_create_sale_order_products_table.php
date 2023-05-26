<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrderProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_order_products', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('tracking');
            $table->integer('product_id');
            $table->integer('attribute_id')->nullable();
            $table->foreignId('sale_order_id')->constrained('sale_orders');
            $table->string('image');
            $table->string('name');
            $table->string('title')->nullable();
            $table->string('serial_number')->nullable();
            $table->string('identity')->nullable();
            $table->string('price');
            $table->string('cost');
            $table->string('qty');
            $table->string('sub_total');
            $table->longText('data');
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
        Schema::dropIfExists('sale_order_products');
    }
}
