<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRepairsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repairs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('tracking');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->string('charges')->default(0);
            $table->string('pre_paid')->default(0);
            $table->string('total_amount')->default(0);
            $table->string('due')->default(0);
            $table->text('tax')->nullable();
            $table->string('tax_amount')->default(0);
            $table->text('issue');
            $table->text('message')->nullable();
            $table->string('device_name');
            $table->string('serial_number');
            $table->string('imei');
            $table->string('by')->nullable();
            $table->boolean('status')->default(0);
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
        Schema::dropIfExists('repairs');
    }
}
