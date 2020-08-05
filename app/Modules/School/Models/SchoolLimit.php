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
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Plan\Models\PlanLimit;

/**
 * Класс модель для таблицы лимитов школы на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolLimit extends Eloquent
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
        'school_id',
        'plan_limit_id',
        'limit',
        'remain'
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
            'school_id' => 'required|integer|digits_between:0,20',
            'plan_limit_id' => 'required|integer|digits_between:0,20',
            'limit' => 'required|integer|digits_between:0,10',
            'remain' => 'required|integer|digits_between:0,10'
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
            'school_id' => trans('school::models.schoolLimit.school_id'),
            'plan_limit_id' => trans('school::models.schoolLimit.plan_limit_id'),
            'limit' => trans('school::models.schoolLimit.limit'),
            'remain' => trans('school::models.schoolLimit.remain')
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
     * Получить лимиты плана.
     *
     * @return \App\Modules\Plan\Models\PlanLimit|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель лимитов плана.
     * @version 1.0
     * @since 1.0
     */
    public function planLimit()
    {
        return $this->belongsTo(PlanLimit::class);
    }
}
