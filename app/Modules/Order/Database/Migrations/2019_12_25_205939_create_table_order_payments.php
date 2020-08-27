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
class CreateTableOrderPayments extends Migration
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
        Schema::create('order_payments', function(Blueprint $table)
        {
            $table->increments('id');

            $table->string('name', 191)->index();
            $table->string('description', 191)->nullable();
            $table->json('parameters')->nullable();
            $table->string('system', 191);
            $table->boolean('online')->default(true);
            $table->bigInteger('image_id')->unsigned()->nullable()->index();
            $table->boolean('status')->default(true)->index();

            $table->timestamps();
            $table->softDeletes()->index();
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
        Schema::drop('order_payments');
    }
}
