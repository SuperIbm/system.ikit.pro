<?php
/**
 * Модуль Заказов.
 * Этот модуль содержит все классы для работы с заказами.
 *
 * @package App\Modules\Order
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Order\Models;

use App\Models\Status;
use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Delete;

/**
 * Класс модель для таблицы выставленных счетов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class OrderInvoice extends Eloquent
{
    use Validate, SoftDeletes, Delete, Status;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        "id",
        "order_id",
        "order_payment_id",
        "invoice",
        "status"
    ];

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getRules(): array
    {
        return [
            "order_id" => 'required|integer|digits_between:1,20',
            "order_payment_id" => 'required|integer|digits_between:1,20',
            "invoice" => 'required|between:1,191|unique_soft:order_invoices,name,' . $this->id . ',id',
            "status" => trans('user::model.orderCharge.status')
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getNames(): array
    {
        return [
            "order_id" => trans('order::model.orderInvoice.order_id'),
            "order_payment_id" => trans('order::model.orderInvoice.order_payment_id'),
            "invoice" => trans('order::model.orderInvoice.invoice'),
            "status" => trans('order::model.orderInvoice.status')
        ];
    }

    /**
     * Получить заказ.
     *
     * @return \App\Modules\Order\Models\Order|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель заказа.
     * @version 1.0
     * @since 1.0
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Получить систему оплаты.
     *
     * @return \App\Modules\Order\Models\OrderPayment|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель системы оплаты.
     * @version 1.0
     * @since 1.0
     */
    public function payment()
    {
        return $this->belongsTo(OrderPayment::class);
    }

    /**
     * Получить оплату.
     *
     * @return \App\Modules\Order\Models\OrderCharge|\Illuminate\Database\Eloquent\Relations\HasMany Модели оплаты.
     * @version 1.0
     * @since 1.0
     */
    public function charge()
    {
        return $this->hasMany(OrderCharge::class);
    }
}
