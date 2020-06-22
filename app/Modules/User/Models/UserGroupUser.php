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
 * Класс модель для таблицы выбранных групп для пользователя на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $user_group_of_user_id
 * @property int $user_group_id
 * @property int $user_id
 *
 * @property-read \App\Modules\User\Models\User $user
 * @property-read \App\Modules\User\Models\UserGroup $userGroup
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupRole[] $userGroupRoles
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupUser whereUserGroupUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroup whereUserGroupId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereUserId($value)
 *
 * @mixin \Eloquent
 */
class UserGroupUser extends Eloquent
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
        'user_group_of_user_id',
        'user_group_id',
        'user_id'
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
            'user_id' => 'required|integer|digits_between:1,20'
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
            'user_id' => 'ID user'
        ];
    }

    /**
     * Получить запись пользователя.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель Пользователь.
     * @version 1.0
     * @since 1.0
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }


    /**
     * Получить запись группы.
     *
     * @return \App\Modules\User\Models\UserGroup[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель Группа пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function userGroups()
    {
        return $this->hasMany(UserGroup::class, 'id', 'user_group_id');
    }
}
