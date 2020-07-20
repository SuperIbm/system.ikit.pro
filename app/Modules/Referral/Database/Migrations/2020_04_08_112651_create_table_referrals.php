<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableReferrals extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('referrals', function(Blueprint $table)
		{
			$table->increments('id');

            $table->string('name', 191);
            $table->string('type', 191)->index('type');
            $table->float('price', 10, 2)->unsigned();
            $table->boolean('percentage')->default(false);

            $table->bigInteger('referral_able_id')->unsigned()->nullable()->index('referral_able_id');
            $table->string('referral_able_type', 191)->nullable()->index('referral_able_type');

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
		Schema::drop('referrals');
	}
}
