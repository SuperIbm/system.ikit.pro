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
use Carbon\Carbon;

/**
 * Класс наполнения начальными данными для установки реферальных программ.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ReferralSeeder extends Seeder
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
        \DB::table('referrals')->delete();

        \DB::table('referrals')->insert(array(
            0 => array(
                "id" => 1,
                "name" => "Пригласи пользователя",
                "type" => "user",
                "price" => 5,
                "percentage" => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));
    }
}
