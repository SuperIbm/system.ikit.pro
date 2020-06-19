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
use App\Modules\Page\Models\Page;
use App\Models\Delete;

/**
 * Класс модель для таблицы выбранных страниц роли на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id
 * @property int $user_role_id
 * @property int $page_id
 *
 * @property-read \App\Modules\User\Models\UserRole $userRole
 * @property-read \App\Modules\Page\Models\Page $page
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRolePage whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRolePage whereUserRoleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserRolePage wherePageId($value)
 *
 * @mixin \Eloquent
 */
class UserRolePage extends Eloquent
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
        'page_id'
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
            'page_id' => 'required|integer|digits_between:1,20'
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
            'page_id' => 'ID page'
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
        return $this->belongsTo(UserRole::class);
    }


    /**
     * Получить страницы сайта.
     *
     * @return \App\Modules\Page\Models\Page|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель страниц сайта.
     * @version 1.0
     * @since 1.0
     */
    public function page()
    {
        return $this->belongsTo(Page::class);
    }
}