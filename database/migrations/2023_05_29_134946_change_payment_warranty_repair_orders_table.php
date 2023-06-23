<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePaymentWarrantyRepairOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('repair_orders', function (Blueprint $table) {
            DB::statement('ALTER TABLE `repair_orders` MODIFY `payment_warranty` LONGTEXT NULL;');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('repair_orders', function (Blueprint $table) {
            //
        });
    }
}
