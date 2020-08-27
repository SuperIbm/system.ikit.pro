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
    public function up(): void
    {
        Schema::create('sections', function(Blueprint $table) {
            $table->increments('id');
            $table->string('index', 191)->index();
            $table->string('label', 191);
            $table->string('icon')->nullable();
            $table->boolean('status')->default(true)->index();

            $table->nestedSet();
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
        Schema::drop('sections');
    }
}
