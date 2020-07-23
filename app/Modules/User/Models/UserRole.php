<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\User\Models;

use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Status;
use App\Models\Delete;
use App\Modules\School\Models\SchoolRole;
use App\Modules\Plan\Models\PlanRole;

/**
 * Класс модель для таблицы ролей пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class UserRole extends Eloquent
{
    use Validate, SoftDeletes, Status, Delete;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'name_role',
        'index',
        'description_role',
        'status'
    ];

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getRules()
    {
        return [
            'name_role' => 'required|between:1,191|unique_soft:user_roles,name_role,' . $this->id . ',id',
            'index' => 'required|between:1,191',
            'description_role' => 'max:191',
            'status' => 'required|boolean'
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getNames()
    {
        return [
            'name_role' => trans('user::model.userRole.name_role'),
            'index' => trans('user::model.userRole.index'),
            'description_role' => trans('user::model.userRole.description_role'),
            'status' => trans('user::model.userRole.status')
        ];
    }

    /**
     * Получить роли школ.
     *
     * @return \App\Modules\School\Models\SchoolRole[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели ролей школы.
     * @version 1.0
     * @since 1.0
     */
    public function schoolRoles()
    {
        return $this->hasMany(SchoolRole::class);
    }

    /**
     * Получить роли тарифа.
     *
     * @return \App\Modules\Plan\Models\PlanRole|\Illuminate\Database\Eloquent\Relations\HasMany Модели роли тарифа.
     * @version 1.0
     * @since 1.0
     */
    public function planRole()
    {
        return $this->hasMany(PlanRole::class);
    }
}
