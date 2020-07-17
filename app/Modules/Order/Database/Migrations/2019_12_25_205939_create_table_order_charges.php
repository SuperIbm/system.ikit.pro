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
    public function up()
    {
        Schema::create('order_charges', function(Blueprint $table)
        {
            $table->increments('id');
            $table->bigInteger('order_invoice_id')->unsigned()->index('order_invoice_id')->nullable();

            $table->string('charge', 191);

            $table->boolean('status')->default(0)->index('status');

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
        Schema::drop('order_charges');
    }
}
