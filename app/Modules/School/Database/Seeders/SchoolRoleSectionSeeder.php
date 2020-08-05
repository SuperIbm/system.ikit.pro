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
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));


        // student

        \DB::table('school_role_sections')->insert(array(
            0 => array(
                'id' => 29,
                'school_role_id' => 3,
                'section_id' => 1, // users
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 30,
                'school_role_id' => 3,
                'section_id' => 2, // courses
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            2 => array(
                'id' => 31,
                'school_role_id' => 3,
                'section_id' => 3, // leads
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            3 => array(
                'id' => 32,
                'school_role_id' => 3,
                'section_id' => 4, // emails
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            4 => array(
                'id' => 33,
                'school_role_id' => 3,
                'section_id' => 5, // automation
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            5 => array(
                'id' => 34,
                'school_role_id' => 3,
                'section_id' => 6, // forms
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            6 => array(
                'id' => 35,
                'school_role_id' => 3,
                'section_id' => 7, // lists
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            7 => array(
                'id' => 36,
                'school_role_id' => 3,
                'section_id' => 8, // processes
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            8 => array(
                'id' => 37,
                'school_role_id' => 3,
                'section_id' => 9, // reports
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            9 => array(
                'id' => 38,
                'school_role_id' => 3,
                'section_id' => 10, // roles
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            10 => array(
                'id' => 39,
                'school_role_id' => 3,
                'section_id' => 11, // site
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            11 => array(
                'id' => 40,
                'school_role_id' => 3,
                'section_id' => 12, // apps
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            12 => array(
                'id' => 41,
                'school_role_id' => 3,
                'section_id' => 13, // settings
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            13 => array(
                'id' => 42,
                'school_role_id' => 3,
                'section_id' => 14, // logs
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
                'school_role_id' => 4,
                'section_id' => 1, // users
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
                'school_role_id' => 4,
                'section_id' => 2, // courses
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
                'school_role_id' => 4,
                'section_id' => 3, // leads
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
                'school_role_id' => 4,
                'section_id' => 4, // emails
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
                'school_role_id' => 4,
                'section_id' => 5, // automation
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
                'school_role_id' => 4,
                'section_id' => 6, // forms
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
                'school_role_id' => 4,
                'section_id' => 7, // lists
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
                'school_role_id' => 4,
                'section_id' => 8, // processes
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
                'school_role_id' => 4,
                'section_id' => 9, // reports
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
                'school_role_id' => 4,
                'section_id' => 10, // roles
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
                'school_role_id' => 4,
                'section_id' => 11, // site
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
                'school_role_id' => 4,
                'section_id' => 12, // apps
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
                'school_role_id' => 4,
                'section_id' => 13, // settings
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
                'school_role_id' => 4,
                'section_id' => 14, // logs
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
                'school_role_id' => 5,
                'section_id' => 1, // users
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
                'school_role_id' => 5,
                'section_id' => 2, // courses
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
                'school_role_id' => 5,
                'section_id' => 3, // leads
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
                'school_role_id' => 5,
                'section_id' => 4, // emails
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
                'school_role_id' => 5,
                'section_id' => 5, // automation
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
                'school_role_id' => 5,
                'section_id' => 6, // forms
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
                'school_role_id' => 5,
                'section_id' => 7, // lists
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
                'school_role_id' => 5,
                'section_id' => 8, // processes
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
                'school_role_id' => 5,
                'section_id' => 9, // reports
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
                'school_role_id' => 5,
                'section_id' => 10, // roles
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
                'school_role_id' => 5,
                'section_id' => 11, // site
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
                'school_role_id' => 5,
                'section_id' => 12, // apps
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
                'school_role_id' => 5,
                'section_id' => 13, // settings
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
                'school_role_id' => 5,
                'section_id' => 14, // logs
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));

        // parent

        \DB::table('school_role_sections')->insert(array(
            0 => array(
                'id' => 71,
                'school_role_id' => 6,
                'section_id' => 1, // users
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 72,
                'school_role_id' => 6,
                'section_id' => 2, // courses
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            2 => array(
                'id' => 73,
                'school_role_id' => 6,
                'section_id' => 3, // leads
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            3 => array(
                'id' => 74,
                'school_role_id' => 6,
                'section_id' => 4, // emails
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            4 => array(
                'id' => 75,
                'school_role_id' => 6,
                'section_id' => 5, // automation
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            5 => array(
                'id' => 76,
                'school_role_id' => 6,
                'section_id' => 6, // forms
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            6 => array(
                'id' => 77,
                'school_role_id' => 6,
                'section_id' => 7, // lists
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            7 => array(
                'id' => 78,
                'school_role_id' => 6,
                'section_id' => 8, // processes
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            8 => array(
                'id' => 79,
                'school_role_id' => 6,
                'section_id' => 9, // reports
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            9 => array(
                'id' => 80,
                'school_role_id' => 6,
                'section_id' => 10, // roles
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            10 => array(
                'id' => 81,
                'school_role_id' => 6,
                'section_id' => 11, // site
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            11 => array(
                'id' => 82,
                'school_role_id' => 6,
                'section_id' => 12, // apps
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            12 => array(
                'id' => 83,
                'school_role_id' => 6,
                'section_id' => 13, // settings
                'read' => false,
                'update' => false,
                'create' => false,
                'destroy' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            13 => array(
                'id' => 84,
                'school_role_id' => 6,
                'section_id' => 14, // logs
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
