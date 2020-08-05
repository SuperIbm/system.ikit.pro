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
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        "price",
        'currency',
        'endless',
        'status'
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
            'name' => 'required|between:1,191|unique_soft:plan_limits,name,' . $this->id . ',id',
            'description' => 'nullable|max:191',
            'type' => 'required|in:place,users,sms',
            'from' => 'required|integer|digits_between:0,20',
            'to' => 'required|integer|digits_between:0,20',
            'step' => 'required|integer|digits_between:0,20',
            'unit' => 'required|between:1,191',
            'price' => 'required|float',
            'currency' => 'required|between:3,3',
            'monthly' => 'required|boolean',
            'endless' => 'required|boolean',
            'status' => 'required|boolean',
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
            'name' => trans('plan::models.planLimit.name'),
            'description' => trans('plan::models.planLimit.description'),
            'type' => trans('plan::models.planLimit.type'),
            'from' => trans('plan::models.planLimit.from'),
            'to' => trans('plan::models.planLimit.to'),
            'step' => trans('plan::models.planLimit.step'),
            'unit' => trans('plan::models.planLimit.unit'),
            'price' => trans('plan::models.planLimit.price'),
            'currency' => trans('plan::models.planLimit.currency'),
            'monthly' => trans('plan::models.planLimit.monthly'),
            'endless' => trans('plan::models.planLimit.endless'),
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
    public function schoolLimits(): HasMany
    {
        return $this->hasMany(SchoolLimit::class);
    }
}
