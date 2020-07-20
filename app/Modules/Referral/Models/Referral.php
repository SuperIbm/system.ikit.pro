<?php
/**
 * Модуль Рефералов.
 * Этот модуль содержит все классы для работы с рефералами.
 *
 * @package App\Modules\Referral
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Referral\Models;

use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Delete;
use App\Models\Status;

/**
 * Класс модель для таблицы реферальных программ на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class Referral extends Eloquent
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
        "name",
        "type",
        "price",
        "percentage",
        "referral_able_id",
        "referral_able_type"
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
            "name" => 'required|between:1,191',
            "type" => 'required|between:1,191',
            "price" => "required|float",
            "percentage" => "required|boolean",
            "referral_able_id" => 'nullable|integer|digits_between:0,20',
            "referral_able_type" => 'nullable|max:191'
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
            "name" => trans('referral::model.referral.name'),
            "type" => trans('referral::model.referral.type'),
            "price" => trans('referral::model.referral.price'),
            "percentage" => trans('referral::model.referral.percentage'),
            "referral_able_id" => trans('referral::model.referral_able_idtype'),
            "referral_able_type" => trans('referral::model.referral_able_type.type'),
        ];
    }

    /**
     * Получить модели к которые относиться заказ.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo Получить модель к которой относиться заказ.
     * @version 1.0
     * @since 1.0
     */
    public function referralable()
    {
        return $this->morphTo("referral_able");
    }
}
