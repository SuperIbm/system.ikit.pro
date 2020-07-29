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
use App\Modules\School\Models\School;
use App\Modules\Order\Models\Order;

/**
 * Класс модель для таблицы тарифов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Plan extends Eloquent
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
        'price_month',
        'price_year',
        'currency',
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
            'name' => 'required|between:1,191|unique_soft:plans,name,' . $this->id . ',id',
            'price_month' => 'required|float',
            'price_year'=> 'required|float',
            'currency' => 'required|between:3,3',
            'status' => 'required|boolean'
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
            'name' => trans('plan::models.plan.name'),
            'price_month' => trans('plan::models.plan.price_month'),
            'price_year'=> trans('plan::models.plan.price_year'),
            'currency' => trans('plan::models.plan.currency'),
            'status' => trans('plan::models.plan.status')
        ];
    }

    /**
     * Получить роли школы.
     *
     * @return \App\Modules\Plan\Models\PlanRole[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели ролей школы.
     * @version 1.0
     * @since 1.0
     */
    public function roles()
    {
        return $this->hasMany(PlanRole::class);
    }

    /**
     * Получить школы этого плана.
     *
     * @return \App\Modules\School\Models\School[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели школы.
     * @version 1.0
     * @since 1.0
     */
    public function schools()
    {
        return $this->hasMany(School::class);
    }

    /**
     * Получение оплаченных заказов этого тарифа.
     *
     * @return \App\Modules\Order\Models\Order[]|\Illuminate\Database\Eloquent\Relations\MorphToMany Модели школы.
     * @version 1.0
     * @since 1.0
     */
    public function orders()
    {
        return $this->morphToMany(Order::class, 'plan');
    }
}
