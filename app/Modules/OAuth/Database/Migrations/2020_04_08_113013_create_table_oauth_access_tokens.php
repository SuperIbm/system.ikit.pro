<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableOauthAccessTokens extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('oauth_tokens', function(Blueprint $table)
		{
            $table->increments('id');
			$table->bigInteger('oauth_client_id')->unsigned()->index();
			$table->string('token', 500);
            $table->dateTime('expires_at')->index();
			$table->timestamps();
		});

        if(Config::get("database.default") != 'sqlite') DB::statement('CREATE UNIQUE INDEX token ON oauth_tokens (token(250));');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::drop('oauth_tokens');
	}
}
