<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('products', function(Blueprint $table)
		{
            $table->engine = 'InnoDB';
            $table->integer('id', true);
            $table->string('code', 192)->nullable();
            $table->string('Type_barcode', 192)->nullable();
            $table->string('slug')->unique();
            $table->string('name', 192);
            $table->longText('description')->nullable();
            $table->float('cost', 10, 0);
            $table->float('price', 10, 0);
            $table->float('out_price', 10, 0);
            $table->integer('category_id')->index('category_id')->nullable();
            $table->integer('brand_id')->nullable()->index('brand_id_products');
            $table->integer('popup_note_id')->nullable();
            $table->integer('unit_id')->nullable()->index('unit_id_products');
            $table->integer('unit_sale_id')->nullable()->index('unit_id_sales');
            $table->string('unit_of_sale')->nullable();
            $table->integer('volume_of_sale')->nullable();
            $table->integer('multi_choice_id')->nullable();
            $table->integer('colour_id')->nullable();
            $table->integer('button_colour_id')->nullable();
            $table->string('sort_position')->nullable();
            $table->string('magento_attribute_set_id')->nullable();
            $table->string('r_r_price')->nullable();
            $table->string('cost_price_tax_rate_id')->nullable();
            $table->integer('product_type')->nullable();
            $table->string('tare_weight')->nullable();
            $table->string('article_code')->nullable();
            $table->integer('unit_purchase_id')->nullable()->index('unit_purchase_products');
            $table->integer('tax_rate_id')->nullable();
            $table->integer('eat_out_tax_rate_id')->nullable();
            $table->float('TaxNet', 10, 0)->nullable()->default(0);
            $table->string('tax_method', 192)->nullable()->default('1');
            $table->text('image')->nullable();
            $table->text('note')->nullable();
            $table->string('size')->nullable();
            $table->string('sku')->nullable();
            $table->boolean('sell_on_web')->default(true);
            $table->boolean('sell_on_till')->default(true);
            $table->boolean('order_code')->default(true);
            $table->float('stock_alert', 10, 0)->nullable()->default(0);
            $table->boolean('is_variant')->default(0);
            // $table->boolean('is_imei')->default(0);
            // $table->boolean('not_selling')->default(0);
            $table->boolean('is_active')->nullable()->default(1);
            $table->timestamps(6);
            $table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('products');
	}

}
