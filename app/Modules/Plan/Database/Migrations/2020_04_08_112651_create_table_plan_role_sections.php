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
            $table->bigInteger('plan_role_id')->unsigned()->index('plan_role_id');
            $table->bigInteger('section_id')->unsigned()->index('section_id');

            $table->boolean('read')->default(0);
            $table->boolean('update')->default(0);
            $table->boolean('create')->default(0);
            $table->boolean('destroy')->default(0);

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
		Schema::drop('plan_role_sections');
	}
}
