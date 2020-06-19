<?php
/**
 * Модуль Типографи.
 * Этот модуль содержит все классы для работы с типографом.
 *
 * @package App\Modules\Typograph
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Typograph\Database\Seeders;

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
        $module = \DB::table('modules')->where('name_module', 'Typograph')->first();

        if(!$module)
        {
            \DB::table('modules')->insert(array(
                0 => array(
                    'name_module' => 'Typograph',
                    'label_module' => 'Typograph',
                    'status' => 1,
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                    'deleted_at' => null
                )
            ));
        }
    }
}
