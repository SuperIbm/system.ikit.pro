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
 * Класс наполнения начальными данными для установки систем оплаты.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OrderPaymentSeeder extends Seeder
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
        \DB::table('order_payments')->delete();

        \DB::table('order_payments')->insert(array(
            0 => array(
                'id' => 1,
                'name' => 'Test',
                'system' => 'Test',
                'online' => true,
                'status' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'deleted_at' => null
            )
        ));
    }
}
