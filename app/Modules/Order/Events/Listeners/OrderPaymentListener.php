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

use ImageStore;
use App\Modules\Order\Models\OrderPayment;

/**
 * Класс обработчик событий для модели систем оплаты.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OrderPaymentListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\Order\Models\OrderPayment $orderPayment Модель для таблицы систем оплаты.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(OrderPayment $orderPayment)
    {
        if($orderPayment->image_id) ImageStore::destroy("order_payment", $orderPayment->image_id["id"]);

        $orderPayment->deleteRelation($orderPayment->invoices(), $orderPayment->isForceDeleting());

        return true;
    }
}
