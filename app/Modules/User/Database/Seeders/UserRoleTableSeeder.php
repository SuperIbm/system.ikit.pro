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

/**
 * Класс наполнения начальными данными ролей по умолчанию.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserRoleTableSeeder extends Seeder
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
        \DB::table('user_roles')->delete();

        \DB::table('user_roles')->insert(array(
            0 =>
                array(
                    'id' => 1,
                    'name' => 'Администратор',
                    'index' => 'admin',
                    'status' => 1,
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Учитель',
                    'index' => 'teacher',
                    'status' => 1,
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Студент',
                    'index' => 'student',
                    'status' => 1,
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'Менеджер',
                    'index' => 'manager',
                    'status' => 1,
                ),
            4 =>
                array(
                    'id' => 5,
                    'name' => 'Эксперт',
                    'index' => 'expert',
                    'status' => 1,
                ),
            5 =>
                array(
                    'id' => 6,
                    'name' => 'Родитель',
                    'index' => 'parent',
                    'status' => 1,
                ),
        ));
    }
}
