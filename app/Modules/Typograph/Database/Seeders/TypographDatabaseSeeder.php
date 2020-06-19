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
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class TypographDatabaseSeeder extends Seeder
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
        Model::unguard();

        $this->call(ModuleTableSeeder::class);
    }
}
