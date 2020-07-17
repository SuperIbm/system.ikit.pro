<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePlanRoles extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('plan_roles', function(Blueprint $table)
		{
			$table->increments('id');
            $table->bigInteger('plan_id')->unsigned()->index('plan_id');
            $table->bigInteger('user_role_id')->unsigned()->index('user_role_id');

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
		Schema::drop('plan_roles');
	}
}
