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
use App\Models\Status;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
    use Validate, SoftDeletes, Delete, Status;

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
        'school_id',
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
            'user_id' => 'required|integer|digits_between:1,20',
            'school_id' => 'required|integer|digits_between:1,20',
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
            'user_id' => trans('user::models.userSchool.user_id'),
            'school_id' => trans('user::models.userSchool.school_id'),
            'status' => trans('user::models.userSchool.status')
        ];
    }

    /**
     * Получить пользователя.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить роли пользователя в рамках школы.
     *
     * @return \App\Modules\User\Models\UserSchoolRole[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели ролей школы.
     * @version 1.0
     * @since 1.0
     */
    public function roles(): HasMany
    {
        return $this->hasMany(UserSchoolRole::class, 'user_id', 'user_id');
    }

    /**
     * Получить школу.
     *
     * @return \App\Modules\School\Models\School|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель школы.
     * @version 1.0
     * @since 1.0
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
