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
 * Класс модель для таблицы оплат на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class OrderCharge extends Eloquent
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
        "order_invoice_id",
        "charge",
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
            "order_invoice_id" => 'required|integer|digits_between:1,20',
            "charge" => 'required|between:1,191',
            "status" => "required|boolean"
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
            "order_invoice_id" => trans('order::model.orderCharge.order_invoice_id'),
            "charge" => trans('order::model.orderCharge.charge'),
            "status" => trans('order::model.orderCharge.status')
        ];
    }

    /**
     * Получить модель выставленного счета.
     *
     * @return \App\Modules\Order\Models\OrderInvoice|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель выставленного счета.
     * @version 1.0
     * @since 1.0
     */
    public function invoice()
    {
        return $this->belongsTo(OrderInvoice::class);
    }

    /**
     * Получить модель возврата денег.
     *
     * @return \App\Modules\Order\Models\OrderRefund|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель ввовзрата денег.
     * @version 1.0
     * @since 1.0
     */
    public function refund()
    {
        return $this->belongsTo(OrderRefund::class);
    }
}
