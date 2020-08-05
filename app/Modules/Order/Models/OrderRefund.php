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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Класс модель для таблицы возврата денег на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class OrderRefund extends Eloquent
{
    use Validate, SoftDeletes, Status, Delete;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        "id",
        "order_charge_id",
        "refund",
        "status"
    ];

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @return array Массив правил валидации для этой модели.
     * @version 1.0
     * @since 1.0
     */
    protected function getRules(): array
    {
        return [
            "order_charge_id" => 'required|integer|digits_between:1,20',
            "refund" => 'required|between:1,191unique_soft:order_refunds,name,' . $this->id . ',id',
            'status' => 'required|bool'
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @return array Массив возможных ошибок валидации.
     * @version 1.0
     * @since 1.0
     */
    protected function getNames(): array
    {
        return [
            "order_charge_id" => trans('order::model.orderRefund.order_charge_id'),
            "refund" => trans('order::model.orderRefund.refund'),
            "status" => trans('order::model.orderRefund.status')
        ];
    }

    /**
     * Получить оплату.
     *
     * @return \App\Modules\Order\Models\OrderCharge[]|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель оплаты.
     * @version 1.0
     * @since 1.0
     */
    public function charge(): BelongsTo
    {
        return $this->belongsTo(OrderCharge::class);
    }
}
