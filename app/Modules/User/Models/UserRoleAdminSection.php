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
use App\Models\Delete;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\AdminSection\Models\AdminSection;

/**
 * Класс модель для таблицы выбранных разделов роли на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id
 * @property int $user_role_id
 * @property int $admin_section_id
 * @property bool $read Значение статуса на чтение.
 * @property bool $update Значение статуса на обновление.
 * @property bool $create Значение статуса на создание.
 * @property bool $destroy Значение статуса на удаление.
 *
 * @property-read \App\Modules\User\Models\UserRole $userRole
 * @property-read \App\Modules\AdminSection\Models\AdminSection $adminSection
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSection whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSection whereUserRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSection whereAdminSectionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSection whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSection whereUpdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSection whereCreate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRoleAdminSection whereDestroy($value)
 *
 * @mixin \Eloquent
 */
class UserRoleAdminSection extends Eloquent
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
        'id',
        'user_role_id',
        'admin_section_id',
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
    protected function getRules()
    {
        return [
            'user_role_id' => 'required|integer|digits_between:1,20',
            'admin_section_id' => 'required|integer|digits_between:1,20',
            'read' => 'boolean',
            'update' => 'boolean',
            'create' => 'boolean',
            'destroy' => 'boolean'
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
            'user_role_id' => 'ID role',
            'admin_section_id' => 'ID admin section',
            'read' => 'Read',
            'update' => 'Update',
            'create' => 'Create',
            'destroy' => 'Destroy'
        ];
    }

    /**
     * Получить запись роли.
     *
     * @return \App\Modules\User\Models\UserRole|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель роли пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function userRole()
    {
        return $this->belongsTo(UserRole::class, 'id_user_role');
    }


    /**
     * Получить раздел адмнистративной системы.
     *
     * @return \App\Modules\AdminSection\Models\AdminSection|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель разделов административной системы.
     * @version 1.0
     * @since 1.0
     */
    public function adminSection()
    {
        return $this->belongsTo(AdminSection::class, 'id_admin_section');
    }
}