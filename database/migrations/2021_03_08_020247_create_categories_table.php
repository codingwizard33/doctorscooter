<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoriesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('categories', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('code', 192)->nullable();
			$table->string('name', 192);
			$table->string('description')->nullable();
			$table->integer('parent_id')->nullable();
            $table->boolean('show_on_till')->default(true);
            $table->boolean('wet')->default(false);
            $table->boolean('button_colour_id')->nullable();
            $table->integer('sort_position')->nullable();
            $table->string('reporting_category_id')->nullable();
            $table->string('nominal_code')->nullable();
            $table->string('slug')->nullable();
            $table->string('image')->nullable();
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
		Schema::drop('categories');
	}

}
