<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableReferrals extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('referrals', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('name', 191)->index();
            $table->string('type', 191)->index();
            $table->float('price', 10, 2)->unsigned();
            $table->boolean('percentage')->default(false);
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
		Schema::drop('referrals');
	}
}
