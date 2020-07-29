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

use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Delete;
use App\Modules\School\Models\School;

/**
 * Класс модель для таблицы заказов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class Order extends Eloquent
{
    use Validate, SoftDeletes, Delete;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        "id",
        "school_id",
        "name",
        "from",
        "to",
        "trial",
        "type",
        "orderable_id",
        "orderable_type"
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
            "school_id" => 'required|integer|digits_between:0,20',
            "name" => 'required|between:1,191',
            "from" => "required|date_format:Y-m-d H:i:s",
            "to" => "nullable|date_format:Y-m-d H:i:s",
            "trial" => "required|boolean",
            "type" => 'required|between:1,191',
            "orderable_id" => 'nullable|integer|digits_between:0,20',
            "orderable_type" => 'nullable|max:191'
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
            "school_id" => trans('order::model.order.school_id'),
            "name" => trans('order::model.order.name'),
            "from" => trans('order::model.order.from'),
            "to" => trans('order::model.order.to'),
            "trial" => trans('order::model.order.trial'),
            "type" => trans('order::model.order.type'),
            "orderable_id" => trans('order::model.order.orderable_id'),
            "orderable_type" => trans('order::model.order.orderable_type')
        ];
    }

    /**
     * Получить школу.
     *
     * @return \App\Modules\School\Models\School|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель школы.
     * @version 1.0
     * @since 1.0
     */
    public function school()
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Получить выставленные счета.
     *
     * @return \App\Modules\Order\Models\OrderInvoice[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели выставленных счетов.
     * @version 1.0
     * @since 1.0
     */
    public function invoices()
    {
        return $this->hasMany(OrderInvoice::class);
    }

    /**
     * Получить модели к которые относиться заказ.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo Получить модель к которой относиться заказ.
     * @version 1.0
     * @since 1.0
     */
    public function orderable()
    {
        return $this->morphTo("orderable");
    }
}
