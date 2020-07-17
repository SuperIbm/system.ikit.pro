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
        "order_able_id",
        "order_able_type"
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
            "order_able_id" => 'nullable|integer|digits_between:0,20',
            "order_able_type" => 'nullable|max:191'
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
            "school_id" => trans('user::model.order.school_id'),
            "name" => trans('user::model.order.name'),
            "from" => trans('user::model.order.from'),
            "to" => trans('user::model.order.to'),
            "trial" => trans('user::model.order.trial'),
            "type" => trans('user::model.order.type'),
            "order_able_id" => trans('user::model.order.order_able_id'),
            "order_able_type" => trans('user::model.order.order_able_type')
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
     * Получить модели к которой относиться заказ.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo Получить модель к которой относиться заказ.
     * @version 1.0
     * @since 1.0
     */
    public function orderable()
    {
        return $this->morphTo("order_able");
    }
}
