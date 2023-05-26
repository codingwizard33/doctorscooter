<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->longText('items');
            $table->string('tracking');
            $table->longText('note')->nullable();
            $table->string('cart_total_cost');
            $table->string('cart_total_items');
            $table->string('cart_total_price');
            $table->string('cart_total_profit');
            $table->longText('tax');
            $table->string('tax_amount');
            $table->string('shipping');
            $table->string('discount');
            $table->string('payable_after_all');
            $table->string('profit_after_all');
            $table->string('recepient_amount');
            $table->string('change_amount');
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
        Schema::dropIfExists('sale_orders');
    }
}
