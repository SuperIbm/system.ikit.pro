<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableOauthAccessTokens extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_tokens', function(Blueprint $table)
		{
            $table->increments('id');
			$table->bigInteger('oauth_client_id')->unsigned()->index();
			$table->string('token', 500);
            $table->dateTime('expires_at')->index();
			$table->timestamps();
		});

        DB::statement('CREATE UNIQUE INDEX token ON oauth_tokens (token(250));');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_tokens');
	}
}
