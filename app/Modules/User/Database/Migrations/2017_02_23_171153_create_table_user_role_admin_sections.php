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
class CreateTableUserRoleAdminSections extends Migration
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
        Schema::create('user_role_admin_sections', function(Blueprint $table)
        {
            $table->bigInteger('id', true)->unsigned();
            $table->bigInteger('user_role_id')->unsigned()->index();
            $table->bigInteger('admin_section_id')->unsigned()->index();
            $table->boolean('read')->default(0);
            $table->boolean('update')->default(0);
            $table->boolean('create')->default(0);
            $table->boolean('destroy')->default(0);

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
        Schema::drop('user_role_admin_sections');
    }

}
