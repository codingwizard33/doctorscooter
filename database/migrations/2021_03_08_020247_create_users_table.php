<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';
			$table->integer('id', true);
			$table->string('firstname');
			$table->string('lastname');
            $table->string('name')->nullable();
			$table->string('username', 192)->nullable();
            $table->text('address')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
			$table->string('email', 192);
			$table->string('password');
			$table->string('avatar')->nullable();
			$table->string('phone', 192)->nullable();
			$table->integer('role_id');
			$table->boolean('statut')->default(1);
            $table->rememberToken();
            $table->boolean('status')->default(true);
//            $table->foreignId('role_id')->constrained('user_roles');
            $table->timestamp('email_verified_at')->nullable();
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
		Schema::drop('users');
	}

}
