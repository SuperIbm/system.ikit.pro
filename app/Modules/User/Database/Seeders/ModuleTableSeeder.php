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
        $module = \DB::table('modules')->where('name_module', 'User')->first();

        if(!$module)
        {
            $moduleId = \DB::table('modules')->insertGetId(array(
                'name_module' => 'User',
                'label_module' => 'Users',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ));

            \DB::table('components')->insert(array(
                0 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Edit',
                    'label_component' => 'Edit',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                ),
                1 => array(
                    'module_id' => $moduleId,
                    'widget' => 'Info',
                    'label_component' => 'Info',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                )
            ));


            $adminSectionId = \DB::table('admin_sections')->insertGetId(array(
                'module_id' => $moduleId,
                'index' => 'users',
                'label_section' => 'Users',
                'bundle' => 'MANAGER',
                'icon' => 'account_circle',
                'weight' => 0,
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ));

            \DB::table('user_role_admin_sections')->insert(array(
                0 => array(
                    'user_role_id' => 1,
                    'admin_section_id' => $adminSectionId,
                    'read' => 1,
                    'update' => 1,
                    'create' => 1,
                    'destroy' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                )
            ));

            \DB::table('user_role_admin_sections')->insert(array(
                0 => array(
                    'user_role_id' => 2,
                    'admin_section_id' => $adminSectionId,
                    'read' => 1,
                    'update' => 1,
                    'create' => 1,
                    'destroy' => 0,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                )
            ));
        }
    }
}
