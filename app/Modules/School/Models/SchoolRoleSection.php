<?php
/**
 * Модуль Школ.
 * Этот модуль содержит все классы для работы школами.
 *
 * @package App\Modules\School
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\School\Models;

use Eloquent;
use App\Models\Validate;
use App\Models\Status;
use App\Models\Delete;
use App\Modules\Section\Models\Section;
use App\Modules\Plan\Models\PlanRoleSection;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Класс модель для таблицы разделов ролей школы на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolRoleSection extends Eloquent
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
        'school_role_id',
        'section_id',
        'plan_role_section_id',
        'read',
        'update',
        'create',
        'destroy'
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
            'school_role_id' => 'required|integer|digits_between:0,20',
            'section_id' => 'required|integer|digits_between:0,20',
            'plan_role_section_id' => 'integer|digits_between:0,20',
            'read' => 'required|boolean',
            'update' => 'nullable|max:191',
            'create' => 'required|boolean',
            'destroy' => 'required|boolean'
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
            'school_role_id' => trans('school::models.schoolRoleSection.school_role_id'),
            'section_id' => trans('school::models.schoolRoleSection.section_id'),
            'plan_role_section_id' => trans('school::models.schoolRoleSection.plan_role_section_id'),
            'read' => trans('school::models.schoolRoleSection.read'),
            'update' => trans('school::models.schoolRoleSection.update'),
            'create' => trans('school::models.schoolRoleSection.create'),
            'destroy' => trans('school::models.schoolRoleSection.destroy'),
        ];
    }

    /**
     * Получить роль школы.
     *
     * @return \App\Modules\School\Models\School|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель роли школы.
     * @version 1.0
     * @since 1.0
     */
    public function role(): BelongsTo
    {
        return $this->belongsTo(SchoolRole::class);
    }

    /**
     * Получить раздел.
     *
     * @return \App\Modules\Section\Models\Section|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель раздела.
     * @version 1.0
     * @since 1.0
     */
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    /**
     * Получить раздел который относиться к разделу плана роли.
     *
     * @return \App\Modules\Plan\Models\PlanRoleSection|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель для таблицы разделов ролей тарифов.
     * @version 1.0
     * @since 1.0
     */
    public function planRoleSection()
    {
        return $this->belongsTo(PlanRoleSection::class);
    }
}
