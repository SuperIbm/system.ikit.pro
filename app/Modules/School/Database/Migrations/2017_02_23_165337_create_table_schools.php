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
class CreateTableSchools extends Migration
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
        Schema::create('schools', function(Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('user_id')->unsigned()->index('user_id');
            $table->bigInteger('plan_id')->unsigned()->index('plan_id');

            $table->bigInteger('image_small_id')->unsigned()->nullable()->index('image_small_id');
            $table->bigInteger('image_middle_id')->unsigned()->nullable()->index('image_middle_id');
            $table->bigInteger('image_big_id')->unsigned()->nullable()->index('image_big_id');

            $table->string('name', 191);
            $table->string('index', 191)->index("index");
            $table->string('full_name', 191)->nullable();
            $table->text('description')->nullable();

            $table->boolean('status')->default(1)->index('status');

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
    public function down()
    {
        Schema::drop('schools');
    }
}
