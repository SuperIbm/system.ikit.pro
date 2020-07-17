<?php
/**
 * Модуль Тарифа.
 * Этот модуль содержит все классы для работы тарифами.
 *
 * @package App\Modules\Plan
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Plan\Models;

use Eloquent;
use App\Models\Validate;
use App\Models\Status;
use App\Models\Delete;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\School\Models\SchoolLimit;

/**
 * Класс модель для таблицы лимитов тарифов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PlanLimit extends Eloquent
{
    use Validate, Status, Delete, SoftDeletes;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'name',
        'description',
        'type',
        'from',
        'to',
        'step',
        'unit',
        'monthly',
        'status'
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
            'name' => 'required|between:1,191',
            'description' => 'nullable|max:191',
            'type' => 'required|in:place,users,sms',
            'from' => 'required|integer|digits_between:0,20',
            'to' => 'required|integer|digits_between:0,20',
            'step' => 'required|integer|digits_between:0,20',
            'unit' => 'required|between:1,191',
            'price' => 'required|float',
            'monthly' => 'required|boolean',
            'status' => 'required|boolean',
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
            'name' => trans('plan::models.planLimit.name'),
            'description' => trans('plan::models.planLimit.description'),
            'type' => trans('plan::models.planLimit.type'),
            'from' => trans('plan::models.planLimit.from'),
            'to' => trans('plan::models.planLimit.to'),
            'step' => trans('plan::models.planLimit.step'),
            'unit' => trans('plan::models.planLimit.unit'),
            'price' => trans('plan::models.planLimit.price'),
            'monthly' => trans('plan::models.planLimit.monthly'),
            'status' => trans('plan::models.planLimit.status'),
        ];
    }

    /**
     * Получить школьные лимиты.
     *
     * @return \App\Modules\School\Models\SchoolLimit[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель раздела.
     * @version 1.0
     * @since 1.0
     */
    public function schoolLimits()
    {
        return $this->hasMany(SchoolLimit::class);
    }
}
