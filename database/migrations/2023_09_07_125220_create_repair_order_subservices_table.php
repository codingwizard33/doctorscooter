<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairOrderSubservicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repair_order_subservices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_table_id');
            $table->foreign('service_table_id')->references('id')->on('repair_order_services')->onDelete('cascade');
            $table->unsignedBigInteger('service_id');
            $table->unsignedBigInteger('subservice_id');
            $table->text('subservice_name');
            $table->string('status');
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
        Schema::dropIfExists('repair_order_subservices');
    }
}
