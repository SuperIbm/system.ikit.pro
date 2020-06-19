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
use App\Models\Delete;

/**
 * Класс модель для таблицы выбранных ролей группы на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property-read \App\Modules\User\Models\UserGroup $userGroup
 * @property-read \App\Modules\User\Models\UserRole $userRole
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRoleAdminSection[] $userRoleAdminSections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRolePage[] $userRolePages
 *
 * @mixin \Eloquent
 */
class UserGroupRole extends Eloquent
{
    use Validate, SoftDeletes, Delete;

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     * @version 1.0
     * @since 1.0
     */
    public $timestamps = true;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'user_group_role_id',
        'user_group_id',
        'user_role_id'
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
            'user_group_id' => 'required|integer|digits_between:1,20',
            'user_role_id' => 'required|integer|digits_between:1,20'
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
            'user_group_id' => 'ID group',
            'user_role_id' => 'ID role'
        ];
    }

    /**
     * Получить запись группы.
     *
     * @return \App\Modules\User\Models\UserGroup|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель Группа пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class);
    }

    /**
     * Получить запись роли.
     *
     * @return \App\Modules\User\Models\UserRole|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель Роли пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function userRole()
    {
        return $this->belongsTo(UserRole::class);
    }

    /**
     * Получить выбранные разделы административной системы для роли.
     *
     * @return \App\Modules\User\Models\UserRoleAdminSection[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель выбранных разделов административной системы для роли.
     * @version 1.0
     * @since 1.0
     */
    public function userRoleAdminSections()
    {
        return $this->hasMany(UserRoleAdminSection::class, "user_role_id", "user_role_id");
    }

    /**
     * Получить запись выбранных страниц сайта.
     *
     * @return \App\Modules\User\Models\UserRoleAdminSection[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель выбранных страниц сайта.
     * @version 1.0
     * @since 1.0
     */
    public function userRolePages()
    {
        return $this->hasMany(UserRolePage::class);
    }
}