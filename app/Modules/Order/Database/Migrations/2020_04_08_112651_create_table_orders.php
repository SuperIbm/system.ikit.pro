<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableOrders extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('orders', function(Blueprint $table)
		{
			$table->increments('id');

			$table->bigInteger('school_id')->unsigned()->index();
			$table->string('name', 191);
            $table->dateTime('from')->index();
            $table->dateTime('to')->index()->nullable();
            $table->boolean('trial')->index()->default(false);
            $table->string('type', 191)->index();
            $table->bigInteger('orderable_id')->unsigned()->nullable()->index();
            $table->string('orderable_type', 191)->nullable()->index();

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
		Schema::drop('orders');
	}
}
