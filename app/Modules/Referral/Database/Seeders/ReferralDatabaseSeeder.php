<?php
/**
 * Модуль Рефералов.
 * Этот модуль содержит все классы для работы с рефералами.
 *
 * @package App\Modules\Referral
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Referral\Database\Seeders;

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
class ReferralDatabaseSeeder extends Seeder
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
        Model::unguard();

        $this->call(ReferralSeeder::class);
    }
}
