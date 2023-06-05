<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('key');
            $table->string('full_name');
            $table->string('phone');
            $table->string('email');
            $table->string('model');
            $table->string('price');
            $table->string('serial_number')->nullable();
            $table->string('bar_code')->nullable();
            $table->longText('information');
            $table->longText('payment_comment');
            $table->string('payment_option');
            $table->string('payment_warranty');
            $table->string('payment_status')->nullable();
            $table->string('status')->default('pending');
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
        Schema::dropIfExists('repair_order');
    }
}
