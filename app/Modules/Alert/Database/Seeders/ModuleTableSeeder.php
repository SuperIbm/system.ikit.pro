<?php
/**
 * Модуль предупреждений.
 * Этот модуль содержит все классы для работы с предупреждениями.
 *
 * @package App\Modules\Alert
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Alert\Database\Seeders;

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
        $module = \DB::table('modules')->where('name_module', 'Alert')->first();

        if(!$module)
        {
            $module_id = \DB::table('modules')->insertGetId(array(
                'name_module' => 'Alert',
                'label_module' => 'Alerts',
                'status' => 1,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ));

            $adminSectionId = \DB::table('admin_sections')->insertGetId(array(
                'module_id' => $module_id,
                'index' => 'alerts',
                'label_section' => 'Alerts',
                'bundle' => 'MANAGER',
                'icon' => 'notification_important',
                'weight' => 1,
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
