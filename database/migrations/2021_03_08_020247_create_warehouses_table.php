<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWarehousesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('warehouses', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->integer('location_area_id')->nullable();
			$table->string('name', 192);
			$table->text('description')->nullable();
			$table->string('address1')->nullable();
			$table->string('address2')->nullable();
			$table->string('city', 192)->nullable();
			$table->string('mobile', 192)->nullable();
			$table->string('zip', 192)->nullable();
			$table->string('email', 192)->nullable();
			$table->string('county', 192)->nullable();
			$table->string('country', 192)->nullable();
			$table->string('post_code', 192)->nullable();
            $table->text('location')->nullable();
            $table->integer('max_volume')->default(10);
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
		Schema::drop('warehouses');
	}

}
