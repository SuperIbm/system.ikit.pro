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
class CreateTableOrderCharges extends Migration
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
        Schema::create('order_charges', function(Blueprint $table)
        {
            $table->increments('id');
            $table->bigInteger('order_invoice_id')->unsigned()->index()->nullable();

            $table->string('charge', 191)->index();
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
        Schema::drop('order_charges');
    }
}
