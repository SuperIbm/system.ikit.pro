<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTablePlanRoleSections extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('plan_role_sections', function(Blueprint $table)
		{
			$table->increments('id');
            $table->bigInteger('plan_role_id')->unsigned()->index();
            $table->bigInteger('section_id')->unsigned()->index();

            $table->boolean('read')->default(0);
            $table->boolean('update')->default(0);
            $table->boolean('create')->default(0);
            $table->boolean('destroy')->default(0);

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
		Schema::drop('plan_role_sections');
	}
}
