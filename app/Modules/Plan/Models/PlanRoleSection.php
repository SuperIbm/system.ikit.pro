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

/**
 * Класс модель для таблицы разделов ролей тарифов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PlanRoleSection extends Eloquent
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
        'plan_role_id',
        'section_id',
        'read',
        'update',
        'create',
        'destroy'
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
            'plan_role_id' => 'required|integer|digits_between:0,20',
            'section_id' => 'required|integer|digits_between:0,20',
            'read' => 'required|boolean',
            'update' => 'required|boolean',
            'create' => 'required|boolean',
            'destroy' => 'required|boolean',
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
            'plan_role_id' => trans('plan::models.planRoleSection.plan_role_id'),
            'section_id' => trans('plan::models.planRoleSection.section_id'),
            'read' => trans('plan::models.planRoleSection.read'),
            'update' => trans('plan::models.planRoleSection.update'),
            'create' => trans('plan::models.planRoleSection.create'),
            'destroy' => trans('plan::models.planRoleSection.destroy')
        ];
    }
}
