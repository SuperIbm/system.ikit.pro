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
 * Класс наполнения начальными данными для установки лимитов плана.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PlanLimitSeeder extends Seeder
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
        \DB::table('plan_limits')->delete();

        \DB::table('plan_limits')->insert(array(
            0 => array(
                'id' => 1,
                'name' => "Пользователей",
                'type' => "user",
                'from' => 1000,
                'to' => 100000,
                'step' => 1000,
                'unit' => "пользователей",
                'price' => 200,
                'currency' => 'RUB',
                'monthly' => true,
                'endless' => true,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            1 => array(
                'id' => 2,
                'name' => "Место на жестком диске",
                'type' => "space",
                'from' => 10,
                'to' => 1000,
                'step' => 10,
                'unit' => "Гб.",
                'price' => 100,
                'currency' => 'RUB',
                'monthly' => true,
                'endless' => true,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            ),
            2 => array(
                'id' => 3,
                'name' => "SMS",
                'type' => "sms",
                'from' => 0,
                'to' => 100000,
                'step' => 1000,
                'unit' => "сообщений",
                'price' => 1500,
                'currency' => 'RUB',
                'monthly' => false,
                'endless' => false,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));
    }
}
