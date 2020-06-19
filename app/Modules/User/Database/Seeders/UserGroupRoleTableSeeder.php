<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\User\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

/**
 * Класс наполнения начальными данными выбранных групп для роли.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserGroupRoleTableSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run()
    {
        \DB::table('user_group_roles')->delete();

        \DB::table('user_group_roles')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'user_group_id' => 1,
                    'user_role_id' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'user_group_id' => 2,
                    'user_role_id' => 2,
                ),
        ));
    }
}
