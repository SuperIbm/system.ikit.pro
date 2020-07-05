<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableOauthRefreshTokens extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('oauth_refresh_tokens', function(Blueprint $table)
		{
            $table->increments('id');
			$table->bigInteger('oauth_token_id')->unsigned()->index();
            $table->string('refresh_token', 500);
			$table->dateTime('expires_at')->index();
            $table->timestamps();
		});

        DB::statement('CREATE UNIQUE INDEX refresh_token ON oauth_refresh_tokens (refresh_token(250));');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('oauth_refresh_tokens');
	}
}
