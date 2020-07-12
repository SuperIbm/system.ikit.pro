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
        'plan_id',
        'limit',
        'date_from',
        'date_to'
    ];

    /**
     * Атрибуты, который содержат дату.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $dates = [
        'date_from',
        'date_to'
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
            'plan_id' => 'required|integer|digits_between:0,20',
            'limit' => 'required|between:1,191',
            'date_from' => 'nullable|date_format:Y-m-d H:i:s',
            'date_to' => 'nullable|date_format:Y-m-d H:i:s',
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
            'plan_id' => trans('school::models.schoolLimit.plan_id'),
            'limit' => trans('school::models.schoolLimit.limit'),
            'date_from' => trans('school::models.schoolLimit.date_from'),
            'date_to' => trans('school::models.schoolLimit.date_to')
        ];
    }
}
