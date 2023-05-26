<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPaginationDefaultColsForPosToSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->string('pos_categories_default_numbers')->default(20)->before('created_at');
            $table->string('pos_products_default_numbers')->default(20)->before('created_at');
            $table->boolean('is_vat')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('settings', function (Blueprint $table) {
            $table->dropColumn(['pos_categories_default_numbers', 'pos_products_default_numbers', 'is_vat']);
        });
    }
}
