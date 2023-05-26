<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEposSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('epos_sales', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id')->nullable();
            $table->string('name');
            $table->text('description');
            $table->string('barcode');
            $table->string('sku');
            $table->string('order_code');
            $table->string('brand');
            $table->string('size');
            $table->integer('qty');
            $table->integer('measured_qty')->nullable();
            $table->float('value')->nullable();
            $table->float('discount')->nullable();
            $table->float('value_inc_vat')->nullable();
            $table->float('value_exc_vat')->nullable();
            $table->float('tot_cost')->nullable();
            $table->float('margin')->nullable();
            $table->float('margin_perc')->nullable();
            $table->integer('reference_code')->nullable();
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
        Schema::dropIfExists('epos_sales');
    }
}
