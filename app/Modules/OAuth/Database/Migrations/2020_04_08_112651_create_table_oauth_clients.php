<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTableOauthClients extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up(): void
	{
		Schema::create('oauth_clients', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user_id')->unsigned()->index('user_id');
			$table->string('secret', 500);
            $table->dateTime('expires_at')->index('expires_at');
			$table->timestamps();
		});

        DB::statement('CREATE UNIQUE INDEX secret ON oauth_clients (secret(250));');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down(): void
	{
		Schema::drop('oauth_clients');
	}
}
