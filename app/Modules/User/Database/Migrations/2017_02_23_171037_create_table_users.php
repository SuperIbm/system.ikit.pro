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
    public function up()
    {
        Schema::create('users', function(Blueprint $table)
        {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('image_small_id')->unsigned()->nullable()->index();
            $table->bigInteger('image_middle_id')->unsigned()->nullable();
            $table->string('login');
            $table->string('password')->index()->nullable();
            $table->string('remember_token', 100)->nullable()->index();
            $table->string('first_name', 150)->nullable();
            $table->string('second_name', 150)->nullable();
            $table->string('email')->nullable();
            $table->string('telephone', 30)->nullable();
            $table->boolean('status')->default(0)->index();
            $table->json('flags')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Запуск отката миграции.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function down()
    {
        Schema::drop('users');
    }

}
