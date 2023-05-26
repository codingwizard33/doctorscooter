<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_bills', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('tracking');
            $table->string('name');
            $table->longText('items')->nullable();
            $table->string('date')->nullable();
            $table->string('time')->nullable();
            $table->string('charges')->default(0)->nullable();
            $table->string('description')->nullable();
            $table->text('tax')->nullable();
            $table->string('tax_amount')->default(0)->nullable();
            $table->string('total_amount')->default(0);
            $table->string('by')->nullable();
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
        Schema::dropIfExists('custom_bills');
    }
}
