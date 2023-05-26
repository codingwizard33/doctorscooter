<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStocksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('tracking');
            $table->integer('product_id')->unsigned();
            $table->integer('product_attribute_id')->nullable()->unsigned();
            $table->integer('warehouse_id')->unsigned();
            $table->integer('rack_number')->default(1);
            $table->string('quantity');
            $table->integer('min_stock')->nullable();
            $table->integer('max_stock')->nullable();
            $table->integer('current_volume')->nullable();
            $table->integer('sold')->default(0);
            $table->integer('returned')->default(0);
            $table->boolean('alerts')->default(1);
            $table->float('cost_price')->nullable();
            $table->unique(['warehouse_id', 'product_id']);
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
        Schema::dropIfExists('stocks');
    }
}
