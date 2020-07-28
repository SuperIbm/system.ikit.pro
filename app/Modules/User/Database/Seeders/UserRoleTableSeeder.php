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

use Carbon\Carbon;
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
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
            1 =>
                array(
                    'id' => 2,
                    'name' => 'Учитель',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
            2 =>
                array(
                    'id' => 3,
                    'name' => 'Студент',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
            3 =>
                array(
                    'id' => 4,
                    'name' => 'Менеджер',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
            4 =>
                array(
                    'id' => 5,
                    'name' => 'Эксперт',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
            5 =>
                array(
                    'id' => 6,
                    'name' => 'Родитель',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
        ));
    }
}
