<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePlans extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('plans', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name', 191)->index();
            $table->float('price_month', 10, 2)->unsigned();
            $table->float('price_year', 10, 2)->unsigned();
            $table->string('currency', 3)->default("RUB");
            $table->boolean('status')->default(true)->index();

			$table->timestamps();
            $table->softDeletes()->index();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::drop('plans');
	}
}
