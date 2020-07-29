<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableOrders extends Migration {

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

			$table->bigInteger('school_id')->unsigned()->index('school_id');
			$table->string('name', 191);
            $table->dateTime('from')->index('from');
            $table->dateTime('to')->index('to')->nullable();
            $table->boolean('trial')->index('trial')->default(false);
            $table->string('type', 191)->index('type');
            $table->bigInteger('orderable_id')->unsigned()->nullable()->index('orderable_id');
            $table->string('orderable_type', 191)->nullable()->index('orderable_type');

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
		Schema::drop('orders');
	}
}
