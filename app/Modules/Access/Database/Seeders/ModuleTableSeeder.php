<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Класс наполнения начальными данными для установки модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ModuleTableSeeder extends Seeder
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
        $module = \DB::table('modules')->where('name_module', 'Access')->first();

        if(!$module)
        {
            $moduleId = \DB::table('modules')->insert([
                'name_module' => 'Access',
                'label_module' => 'Access',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ]);

            \DB::table('components')->insert(array(
                0 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Login',
                    'label_component' => 'Login',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                1 => array(
                    'module_id' => $moduleId,
                    'widget' => 'SignUp',
                    'label_component' => 'Sign up',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                2 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Forget',
                    'label_component' => 'Forget',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                3 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Verified',
                    'label_component' => 'Verified',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                4 => array(
                    'module_id' => $moduleId,
                    'widget' => 'LogOut',
                    'label_component' => 'Log out',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                5 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Get',
                    'label_component' => 'Get',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                6 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Verify',
                    'label_component' => 'Verify',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                7 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Reset',
                    'label_component' => 'Reset',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                8 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Edit',
                    'label_component' => 'Edit',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                9 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Change password',
                    'label_component' => 'ChangePassword',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                10 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Success',
                    'label_component' => 'Success',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                11 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Wall',
                    'label_component' => 'Wall',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
            ));
        }
    }
}
