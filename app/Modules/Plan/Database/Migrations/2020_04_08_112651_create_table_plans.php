<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePlans extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191);
            $table->float('priceMonth', 8, 2)->unsigned();
            $table->float('priceYear', 8, 2)->unsigned();
            $table->boolean('status')->default(1)->index('status');

			$table->timestamps();
            $table->softDeletes()->index('deleted_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('plans');
	}
}
