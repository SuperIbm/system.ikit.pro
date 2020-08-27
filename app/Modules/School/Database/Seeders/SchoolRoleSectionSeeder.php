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
 * Класс наполнения начальными данными для установки доступов к разделам для школы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolRoleSectionSeeder extends Seeder
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
        \DB::table('school_role_sections')->delete();

        // admin

        \DB::table('school_role_sections')->insert(array(
            0 => array(
                'id' => 1,
                'school_role_id' => 1,
                'section_id' => 1, // users
                'plan_role_section_id' => 1,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 2,
                'school_role_id' => 1,
                'section_id' => 2, // courses
                'plan_role_section_id' => 2,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            2 => array(
                'id' => 3,
                'school_role_id' => 1,
                'section_id' => 3, // leads
                'plan_role_section_id' => 3,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            3 => array(
                'id' => 4,
                'school_role_id' => 1,
                'section_id' => 4, // emails
                'plan_role_section_id' => 4,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            4 => array(
                'id' => 5,
                'school_role_id' => 1,
                'section_id' => 5, // automation
                'plan_role_section_id' => 5,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            5 => array(
                'id' => 6,
                'school_role_id' => 1,
                'section_id' => 6, // forms
                'plan_role_section_id' => 6,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            6 => array(
                'id' => 7,
                'school_role_id' => 1,
                'section_id' => 7, // lists
                'plan_role_section_id' => 7,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            7 => array(
                'id' => 8,
                'school_role_id' => 1,
                'section_id' => 8, // processes
                'plan_role_section_id' => 8,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            8 => array(
                'id' => 9,
                'school_role_id' => 1,
                'section_id' => 9, // reports
                'plan_role_section_id' => 9,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            9 => array(
                'id' => 10,
                'school_role_id' => 1,
                'section_id' => 10, // roles
                'plan_role_section_id' => 10,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            10 => array(
                'id' => 11,
                'school_role_id' => 1,
                'section_id' => 11, // site
                'plan_role_section_id' => 11,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            11 => array(
                'id' => 12,
                'school_role_id' => 1,
                'section_id' => 12, // apps
                'plan_role_section_id' => 12,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            12 => array(
                'id' => 13,
                'school_role_id' => 1,
                'section_id' => 13, // settings
                'plan_role_section_id' => 13,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            13 => array(
                'id' => 14,
                'school_role_id' => 1,
                'section_id' => 14, // logs
                'plan_role_section_id' => 14,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));


        // teacher

        \DB::table('school_role_sections')->insert(array(
            0 => array(
                'id' => 15,
                'school_role_id' => 2,
                'section_id' => 1, // users
                'plan_role_section_id' => 1,
                'read' => true,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 16,
                'school_role_id' => 2,
                'section_id' => 2, // courses
                'plan_role_section_id' => 2,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            2 => array(
                'id' => 17,
                'school_role_id' => 2,
                'section_id' => 3, // leads
                'plan_role_section_id' => 3,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            3 => array(
                'id' => 18,
                'school_role_id' => 2,
                'section_id' => 4, // emails
                'plan_role_section_id' => 4,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            4 => array(
                'id' => 19,
                'school_role_id' => 2,
                'section_id' => 5, // automation
                'plan_role_section_id' => 5,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            5 => array(
                'id' => 20,
                'school_role_id' => 2,
                'section_id' => 6, // forms
                'plan_role_section_id' => 6,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            6 => array(
                'id' => 21,
                'school_role_id' => 2,
                'section_id' => 7, // lists
                'plan_role_section_id' => 7,
                'read' => true,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            7 => array(
                'id' => 22,
                'school_role_id' => 2,
                'section_id' => 8, // processes
                'plan_role_section_id' => 8,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            8 => array(
                'id' => 23,
                'school_role_id' => 2,
                'section_id' => 9, // reports
                'plan_role_section_id' => 9,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            9 => array(
                'id' => 24,
                'school_role_id' => 2,
                'section_id' => 10, // roles
                'plan_role_section_id' => 10,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            10 => array(
                'id' => 25,
                'school_role_id' => 2,
                'section_id' => 11, // site
                'plan_role_section_id' => 11,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            11 => array(
                'id' => 26,
                'school_role_id' => 2,
                'section_id' => 12, // apps
                'plan_role_section_id' => 12,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            12 => array(
                'id' => 27,
                'school_role_id' => 2,
                'section_id' => 13, // settings
                'plan_role_section_id' => 13,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            13 => array(
                'id' => 28,
                'school_role_id' => 2,
                'section_id' => 14, // logs
                'plan_role_section_id' => 14,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));


        // manager

        \DB::table('school_role_sections')->insert(array(
            0 => array(
                'id' => 43,
                'school_role_id' => 3,
                'section_id' => 1, // users
                'plan_role_section_id' => 1,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 44,
                'school_role_id' => 3,
                'section_id' => 2, // courses
                'plan_role_section_id' => 2,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            2 => array(
                'id' => 45,
                'school_role_id' => 3,
                'section_id' => 3, // leads
                'plan_role_section_id' => 3,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            3 => array(
                'id' => 46,
                'school_role_id' => 3,
                'section_id' => 4, // emails
                'plan_role_section_id' => 4,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            4 => array(
                'id' => 47,
                'school_role_id' => 3,
                'section_id' => 5, // automation
                'plan_role_section_id' => 5,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            5 => array(
                'id' => 48,
                'school_role_id' => 3,
                'section_id' => 6, // forms
                'plan_role_section_id' => 6,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            6 => array(
                'id' => 49,
                'school_role_id' => 3,
                'section_id' => 7, // lists
                'plan_role_section_id' => 7,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            7 => array(
                'id' => 50,
                'school_role_id' => 3,
                'section_id' => 8, // processes
                'plan_role_section_id' => 8,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            8 => array(
                'id' => 51,
                'school_role_id' => 3,
                'section_id' => 9, // reports
                'plan_role_section_id' => 9,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            9 => array(
                'id' => 52,
                'school_role_id' => 3,
                'section_id' => 10, // roles
                'plan_role_section_id' => 10,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            10 => array(
                'id' => 53,
                'school_role_id' => 3,
                'section_id' => 11, // site
                'plan_role_section_id' => 11,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            11 => array(
                'id' => 54,
                'school_role_id' => 3,
                'section_id' => 12, // apps
                'plan_role_section_id' => 12,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            12 => array(
                'id' => 55,
                'school_role_id' => 3,
                'section_id' => 13, // settings
                'plan_role_section_id' => 13,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            13 => array(
                'id' => 56,
                'school_role_id' => 3,
                'section_id' => 14, // logs
                'plan_role_section_id' => 14,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));


        // expert

        \DB::table('school_role_sections')->insert(array(
            0 => array(
                'id' => 57,
                'school_role_id' => 4,
                'section_id' => 1, // users
                'plan_role_section_id' => 1,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 58,
                'school_role_id' => 4,
                'section_id' => 2, // courses
                'plan_role_section_id' => 2,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            2 => array(
                'id' => 59,
                'school_role_id' => 4,
                'section_id' => 3, // leads
                'plan_role_section_id' => 3,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            3 => array(
                'id' => 60,
                'school_role_id' => 4,
                'section_id' => 4, // emails
                'plan_role_section_id' => 4,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            4 => array(
                'id' => 61,
                'school_role_id' => 4,
                'section_id' => 5, // automation
                'plan_role_section_id' => 5,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            5 => array(
                'id' => 62,
                'school_role_id' => 4,
                'section_id' => 6, // forms
                'plan_role_section_id' => 6,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            6 => array(
                'id' => 63,
                'school_role_id' => 4,
                'section_id' => 7, // lists
                'plan_role_section_id' => 7,
                'read' => true,
                'update' => true,
                'create' => true,
                'destroy' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            7 => array(
                'id' => 64,
                'school_role_id' => 4,
                'section_id' => 8, // processes
                'plan_role_section_id' => 8,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            8 => array(
                'id' => 65,
                'school_role_id' => 4,
                'section_id' => 9, // reports
                'plan_role_section_id' => 9,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            9 => array(
                'id' => 66,
                'school_role_id' => 4,
                'section_id' => 10, // roles
                'plan_role_section_id' => 10,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            10 => array(
                'id' => 67,
                'school_role_id' => 4,
                'section_id' => 11, // site
                'plan_role_section_id' => 11,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            11 => array(
                'id' => 68,
                'school_role_id' => 4,
                'section_id' => 12, // apps
                'plan_role_section_id' => 12,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            12 => array(
                'id' => 69,
                'school_role_id' => 4,
                'section_id' => 13, // settings
                'plan_role_section_id' => 13,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            13 => array(
                'id' => 70,
                'school_role_id' => 4,
                'section_id' => 14, // logs
                'plan_role_section_id' => 14,
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));
    }
}
