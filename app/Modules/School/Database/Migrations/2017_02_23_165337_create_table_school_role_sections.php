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
class CreateTableSchoolRoleSections extends Migration
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
        Schema::create('school_role_sections', function(Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();

            $table->bigInteger('school_role_id')->unsigned()->index();
            $table->bigInteger('section_id')->unsigned()->index();
            $table->bigInteger('plan_role_section_id')->unsigned()->index()->nullable();

            $table->boolean('read')->default(0);
            $table->boolean('update')->default(0);
            $table->boolean('create')->default(0);
            $table->boolean('destroy')->default(0);

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
        Schema::drop('school_role_sections');
    }
}
