<?php
/**
 * Модуль Тарифа.
 * Этот модуль содержит все классы для работы тарифами.
 *
 * @package App\Modules\Plan
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Plan\Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Класс наполнения начальными данными для установки доступов к разделам для плана.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PlanRoleSectionSeeder extends Seeder
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
        \DB::table('plan_role_sections')->delete();

        // admin

        \DB::table('plan_role_sections')->insert(array(
            0 => array(
                'id' => 1,
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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
                'plan_role_id' => 1,
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

        \DB::table('plan_role_sections')->insert(array(
            0 => array(
                'id' => 15,
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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
                'plan_role_id' => 2,
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

        \DB::table('plan_role_sections')->insert(array(
            0 => array(
                'id' => 29,
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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
                'plan_role_id' => 3,
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

        \DB::table('plan_role_sections')->insert(array(
            0 => array(
                'id' => 43,
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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
                'plan_role_id' => 4,
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

        \DB::table('plan_role_sections')->insert(array(
            0 => array(
                'id' => 57,
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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
                'plan_role_id' => 5,
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

        \DB::table('plan_role_sections')->insert(array(
            0 => array(
                'id' => 71,
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
                'plan_role_id' => 6,
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
