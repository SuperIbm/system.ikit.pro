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
class CreateTableAlerts extends Migration
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
        Schema::create('alerts', function(Blueprint $table)
        {
            $table->bigInteger('id', true)->unsigned();
            $table->string('title', 191)->nullable();
            $table->string('description', 1000)->nullable();
            $table->string('url', 191)->nullable();
            $table->string('icon', 50)->nullable();
            $table->string('color', 50)->nullable();
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
        Schema::drop('alerts');
    }
}
