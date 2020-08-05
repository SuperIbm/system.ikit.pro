<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

/**
 * Класс миграции.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CreateTableUsers extends Migration
{

    /**
     * Запуск миграции.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function up(): void
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('image_small_id')->unsigned()->nullable()->index('image_small_id');
            $table->bigInteger('image_middle_id')->unsigned()->nullable();
            $table->string('login')->index('login');
            $table->string('password')->index('password')->nullable();
            $table->string('remember_token', 100)->nullable()->index('remember_token');
            $table->string('first_name', 150)->nullable();
            $table->string('second_name', 150)->nullable();
            $table->string('telephone', 30)->nullable();
            $table->boolean('two_factor')->default(0)->index('two_factor');
            $table->boolean('status')->default(0)->index('status');
            $table->json('flags')->nullable();

            $table->timestamps();
            $table->softDeletes()->index('deleted_at');
        });
    }

    /**
     * Запуск отката миграции.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function down(): void
    {
        Schema::drop('users');
    }

}
