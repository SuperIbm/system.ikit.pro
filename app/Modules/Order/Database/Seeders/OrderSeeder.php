<?php
/**
 * Модуль Заказов.
 * Этот модуль содержит все классы для работы с заказами.
 *
 * @package App\Modules\Order
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Order\Database\Seeders;

use Illuminate\Database\Seeder;
use Carbon\Carbon;

/**
 * Класс наполнения начальными данными для установки осуществленных заказов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OrderSeeder extends Seeder
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
        \DB::table('orders')->delete();

        \DB::table('orders')->insert(array(
            0 => array(
                "id" => 1,
                "school_id" => 1,
                "name" => "Оплата за пользованием системы",
                "from" => Carbon::now(),
                "to" => Carbon::now()->addMonth(),
                "trial" => false,
                "type" => "system",
                "orderable_id" => 1,
                "orderable_type" => '\App\Modules\Plan\Models\Plan',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            1 => array(
                "id" => 2,
                "school_id" => 1,
                "name" => "Оплата за пользователей",
                "from" => Carbon::now(),
                "to" => Carbon::now()->addMonth(),
                "trial" => false,
                "type" => "user",
                "orderable_id" => 1,
                "orderable_type" => '\App\Modules\Plan\Models\PlanLimit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            2 => array(
                "id" => 3,
                "school_id" => 1,
                "name" => "Оплата за место на жестком диске",
                "from" => Carbon::now(),
                "to" => Carbon::now()->addMonth(),
                "trial" => false,
                "type" => "space",
                "orderable_id" => 2,
                "orderable_type" => '\App\Modules\Plan\Models\PlanLimit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ),
            3 => array(
                "id" => 4,
                "school_id" => 1,
                "name" => "Оплата за СМС",
                "from" => Carbon::now(),
                "to" => null,
                "trial" => false,
                "type" => "sms",
                "orderable_id" => 3,
                "orderable_type" => '\App\Modules\Plan\Models\PlanLimit',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            )
        ));
    }
}
