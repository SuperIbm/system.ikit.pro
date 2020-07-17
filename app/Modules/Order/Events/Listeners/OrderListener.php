<?php
/**
 * Модуль Заказов.
 * Этот модуль содержит все классы для работы с заказами.
 *
 * @package App\Modules\Order
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Order\Events\Listeners;

use App\Modules\Order\Models\Order;

/**
 * Класс обработчик событий для модели заказов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OrderListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\Order\Models\Order $order Модель для таблицы заказов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(Order $order)
    {
        $order->deleteRelation($order->invoices(), $order->isForceDeleting());

        return true;
    }
}
