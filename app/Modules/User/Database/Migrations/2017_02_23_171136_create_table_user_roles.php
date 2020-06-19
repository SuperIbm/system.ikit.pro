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
class CreateTableUserRoles extends Migration
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
        Schema::create('user_roles', function(Blueprint $table)
        {
            $table->bigInteger('id', true)->unsigned();
            $table->string('name_role', 191);
            $table->string('description_role', 191)->nullable();
            $table->boolean('status')->default(0)->index();

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
        Schema::drop('user_roles');
    }

}
