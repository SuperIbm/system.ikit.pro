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
 * Класс модель для таблицы выбранных страницы группы на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property-read \App\Modules\User\Models\UserGroup $userGroup
 * @property-read \App\Modules\Page\Models\Page $user
 * @property-read \App\Modules\Page\Models\Page $page
 *
 * @mixin \Eloquent
 */
class UserGroupPage extends Eloquent
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
        'user_group_page_id',
        'user_group_id',
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
            'user_group_id' => 'required|integer|digits_between:1,20',
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
            'user_group_id' => 'ID group',
            'page_id' => 'ID page'
        ];
    }


    /**
     * Получить запись группы пользователя.
     *
     * @return \App\Modules\User\Models\UserGroup|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель группа пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class);
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