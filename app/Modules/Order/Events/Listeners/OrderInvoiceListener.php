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

use App\Modules\Order\Models\OrderInvoice;

/**
 * Класс обработчик событий для модели выставленных счетов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OrderInvoiceListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\Order\Models\OrderInvoice $orderInvoice Модель для таблицы выставленных счетов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(OrderInvoice $orderInvoice): bool
    {
        $orderInvoice->deleteRelation($orderInvoice->charge(), $orderInvoice->isForceDeleting());

        return true;
    }
}
