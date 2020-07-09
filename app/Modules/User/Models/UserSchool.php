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
use App\Modules\School\Models\School;

/**
 * Класс модель для таблицы соотношений пользователя со школами на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class UserSchool extends Eloquent
{
    use Validate, SoftDeletes, Delete;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'user_id',
        'school_id'
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
            'user_id' => 'required|integer|digits_between:1,20',
            'school_id' => 'required|integer|digits_between:1,20'
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
            'user_id' => trans('user::model.userSchool.user_id'),
            'school_id' => trans('user::model.userSchool.school_id')
        ];
    }

    /**
     * Получить пользователя.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
}
