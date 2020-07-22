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
 * Класс наполнения начальными данными для установки школы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolSeeder extends Seeder
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
        $schoolId = \DB::table('schools')->insertGetId(array(
            'id' => 1,
            'user_id' => 1,
            'name' => "Test",
            'index' => "test",
            'full_name' => "Test",
            'status' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'deleted_at' => null
        ));

        \DB::table('school_limit')->insert(array(
            0 => array(
                'id' => 1,
                'school_id' => $schoolId,
                'plan_limit_id' => 1,
                'limit' => 1000,
                'remain' => 1000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 1,
                'school_id' => $schoolId,
                'plan_limit_id' => 2,
                'limit' => 10,
                'remain' => 10,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 1,
                'school_id' => $schoolId,
                'plan_limit_id' => 3,
                'limit' => 1000,
                'remain' => 1000,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));
    }
}
