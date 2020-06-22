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
 * Класс модель для таблицы групп пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id
 * @property string $name_group
 * @property string $status Значение статуса.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserGroupUser[] $userGroupUsers
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroup whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroup whereNameGroup($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroup whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroup active($status = true)
 *
 * @mixin \Eloquent
 */
class UserGroup extends Eloquent
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
        'name_group',
        'description_group',
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
            'name_group' => 'required|between:1,100|unique_soft:user_groups,name_group,' . $this->id . ',id',
            'description_group' => 'max:191',
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
            'name_group' => 'Name group',
            'description_group' => 'Description',
            'status' => 'Status'
        ];
    }

    /**
     * Получить запись выбранных групп.
     *
     * @return \App\Modules\User\Models\UserGroupUser[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель Группа выбранных групп.
     * @version 1.0
     * @since 1.0
     */
    public function userGroupUsers()
    {
        return $this->hasMany(UserGroupUser::class);
    }
}
