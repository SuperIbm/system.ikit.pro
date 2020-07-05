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
class CreateTableSections extends Migration
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
        Schema::create('admin_sections', function(Blueprint $table) {
            $table->increments('id');
            $table->string('index', 191)->index();
            $table->string('label', 191);
            $table->string('icon')->nullable();
            $table->boolean('status')->default(0)->index();

            $table->nestedSet();
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
        Schema::drop('admin_sections');
    }
}
