<?php
/**
 * Модуль Кеширования.
 * Этот модуль содержит все классы для работы с кешированием.
 *
 * @package App\Modules\Cache
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Cache\Database\Seeders;

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
        $module = \DB::table('modules')->where('name_module', 'Cache')->first();

        if(!$module)
        {
            \DB::table('modules')->insert(array(
                0 => array(
                    'name_module' => 'Cache',
                    'label_module' => 'Cache',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                )
            ));
        }
    }
}
