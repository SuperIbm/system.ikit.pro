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

use App\Modules\Order\Models\OrderCharge;

/**
 * Класс обработчик событий для модели оплаченных счетов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OrderChargeListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\Order\Models\OrderCharge $orderCharge Модель для таблицы оплаченных счетов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(OrderCharge $orderCharge): bool
    {
        $orderCharge->deleteRelation($orderCharge->refund(), $orderCharge->isForceDeleting());

        return true;
    }
}
