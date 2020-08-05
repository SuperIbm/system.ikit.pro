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
        'name',
        'description',
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
            'name' => 'required|between:1,191|unique_soft:user_roles,name,' . $this->id . ',id',
            'description' => 'max:191',
            'status' => 'required|boolean'
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
            'name' => trans('user::model.userRole.name'),
            'description' => trans('user::model.userRole.description'),
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
