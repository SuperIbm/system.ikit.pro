<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePlanRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('plan_roles', function(Blueprint $table)
		{
			$table->increments('id');
            $table->bigInteger('plan_id')->unsigned()->index();
            $table->bigInteger('user_role_id')->unsigned()->index();

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
		Schema::drop('plan_roles');
	}
}
