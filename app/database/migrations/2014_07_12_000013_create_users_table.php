<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table) {

            $table->increments('id');

            $table->string('email');

            $table->string('username');
			
			$table->string('first_name');
			
			$table->string('last_name');
			
            $table->string('mobile');

            $table->tinyInteger('admin')->default(0);

            $table->tinyInteger('manager')->default(0);

            $table->string('password');

            $table->string('remember_token')->nullable();

            $table->integer('city');//->default(NULL)

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
		Schema::drop('users');
	}

}
