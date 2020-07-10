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
use App\Modules\User\Models\UserRole;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Класс модель для таблицы ролей школы на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolRole extends Eloquent
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
        'user_role_id',
        'name_role',
        'description_role',
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
            'school_id' => 'nullable|integer|digits_between:0,20',
            'user_role_id' => 'required|integer|digits_between:0,20',
            'name_role' => 'required|between:1,191',
            'description_role' => 'nullable|max:191',
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
            'school_id' => trans('school::models.schoolRole.school_id'),
            'user_role_id' => trans('school::models.schoolRole.user_role_id'),
            'name_role' => trans('school::models.schoolRole.name'),
            'description_role' => trans('school::models.schoolRole.description_role'),
            'status' => trans('school::models.schoolRole.status'),
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
     * Получить роль пользователя.
     *
     * @return \App\Modules\User\Models\UserRole|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель роли пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    /**
     * Получить разделы школы.
     *
     * @return \App\Modules\School\Models\SchoolRoleSection[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель разделов школ для роли.
     * @version 1.0
     * @since 1.0
     */
    public function sections()
    {
        return $this->hasMany(SchoolRoleSection::class);
    }
}
