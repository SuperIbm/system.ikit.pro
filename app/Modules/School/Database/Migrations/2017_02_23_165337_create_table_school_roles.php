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
class CreateTableSchoolRoles extends Migration
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
        Schema::create('school_roles', function(Blueprint $table) {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('school_id')->unsigned()->index('school_id');
            $table->bigInteger('user_role_id')->unsigned()->nullable()->index('user_role_id');

            $table->string('name_role', 191);
            $table->string('description_role', 191)->nullable();

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
        Schema::drop('school_roles');
    }
}
