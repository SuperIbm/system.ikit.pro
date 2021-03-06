<?php
/**
 * Модуль Школ.
 * Этот модуль содержит все классы для работы школами.
 *
 * @package App\Modules\School
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\School\Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Класс наполнения начальными данными для установки ролей школы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolRoleSeeder extends Seeder
{
    /**
     * Запуск наполнения начальными данными.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function run(): void
    {
        \DB::table('school_roles')->delete();

        \DB::table('school_roles')->insert(array(
            0 => array(
                'id' => 1,
                'school_id' => 1,
                'user_role_id' => 1,
                'name' => "Администратор",
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 2,
                'school_id' => 1,
                'user_role_id' => 2,
                'name' => 'Учитель',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            2 => array(
                'id' => 3,
                'school_id' => 1,
                'user_role_id' => 3,
                'name' => 'Менеджер',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            3 => array(
                'id' => 4,
                'school_id' => 1,
                'user_role_id' => 4,
                'name' => 'Эксперт',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));
    }
}
