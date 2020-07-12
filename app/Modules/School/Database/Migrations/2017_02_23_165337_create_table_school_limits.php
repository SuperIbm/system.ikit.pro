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
class CreateTableSchoolLimits extends Migration
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
        Schema::create('school_limits', function(Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('plan_id')->unsigned()->index();
            $table->integer('limit')->unsigned();
            $table->dateTime('date_from')->nullable();
            $table->dateTime('date_to')->nullable();

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
        Schema::drop('school_limits');
    }
}
