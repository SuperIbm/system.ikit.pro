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
use Illuminate\Database\Eloquent\Model;

/**
 * Класс для запуска установки начальными данными.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OrderDatabaseSeeder extends Seeder
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

        $this->call(OrderPaymentSeeder::class);
        $this->call(OrderSeeder::class);
    }
}
