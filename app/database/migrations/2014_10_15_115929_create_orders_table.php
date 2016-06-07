<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateOrdersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('comment');

            $table->string('process');

            $table->string('price');

            $table->unsignedInteger('costumer');
            $table->unsignedInteger('service');

            $table->foreign('costumer')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service')->references('id')->on('services');

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
		Schema::drop('orders');
	}

}
