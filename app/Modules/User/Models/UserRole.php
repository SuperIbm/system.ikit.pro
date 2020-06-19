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

/**
 * Класс модель для таблицы ролей пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID роли.
 * @property string $name_role Название роли.
 * @property string $status Значение статуса.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupRole[] $userGroupRoles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRoleAdminSection[] $userRoleAdminSections
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRolePage[] $userRolePages
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRole whereUserRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRole whereNameRole($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRole whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRole active($status = true)
 *
 * @mixin \Eloquent
 */
class UserRole extends Eloquent
{
    use Validate, SoftDeletes, Status, Delete;

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
        'id',
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
    protected function getRules()
    {
        return [
            'name_role' => 'required|between:1,100|unique_soft:user_roles,name_role,' . $this->id . ',id',
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
            'name_role' => 'Name',
            'description_role' => 'Description',
            'status' => 'Status'
        ];
    }


    /**
     * Получить запись выбранных ролей.
     *
     * @return \App\Modules\User\Models\UserGroupRole[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель выбранных ролей.
     * @version 1.0
     * @since 1.0
     */
    public function userGroupRoles()
    {
        return $this->hasMany(UserGroupRole::class);
    }


    /**
     * Получить запись выбранных разделов административной системы.
     *
     * @return \App\Modules\User\Models\UserRoleAdminSection[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель выбранных разделов административной системы.
     * @version 1.0
     * @since 1.0
     */
    public function userRoleAdminSections()
    {
        return $this->hasMany(UserRoleAdminSection::class);
    }

    /**
     * Получить запись выбранных страниц сайта.
     *
     * @return \App\Modules\User\Models\UserRolePage[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель выбранных страниц сайта.
     * @version 1.0
     * @since 1.0
     */
    public function userRolePages()
    {
        return $this->hasMany(UserRolePage::class);
    }
}