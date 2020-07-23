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
 * Класс наполнения начальными данными для установки лимитов для школы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolLimitSeeder extends Seeder
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
        \DB::table('school_limits')->delete();

        \DB::table('school_limits')->insert(array(
            0 => array(
                'id' => 1,
                'school_id' => 1,
                'plan_limit_id' => 1,
                'limit' => 1000,
                'remain' => 1000
            ),
            1 => array(
                'id' => 2,
                'school_id' => 1,
                'plan_limit_id' => 2,
                'limit' => 10,
                'remain' => 10
            ),
            2 => array(
                'id' => 2,
                'school_id' => 1,
                'plan_limit_id' => 3,
                'limit' => 1000,
                'remain' => 1000
            )
        ));
    }
}
