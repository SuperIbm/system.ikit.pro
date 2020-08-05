<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePlanLimits extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('plan_limits', function(Blueprint $table)
		{
			$table->increments('id');

			$table->string('name', 191)->index("name");
            $table->string('description', 191)->nullable();
            $table->string('type', 191)->index('type');
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned()->nullable();
            $table->integer('step')->unsigned();
            $table->string('unit', 50);
            $table->float('price', 8, 2)->unsigned();
            $table->string('currency', 3)->default("RUB");
            $table->boolean('monthly')->default(0);
            $table->boolean('endless')->default(0);
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
	public function down(): void
	{
		Schema::drop('plan_limits');
	}
}
