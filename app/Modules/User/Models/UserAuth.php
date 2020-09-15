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
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Класс модель для таблицы хранения данных о аунтификации пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class UserAuth extends Eloquent
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
        'os',
        'device',
        'browser',
        'agent',
        'ip',
        'latitude',
        'longitude'
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
            'os' => 'nullable|max:191',
            'device' => 'nullable|max:191',
            'browser' => 'nullable|max:191',
            'agent' => 'nullable|max:191',
            'ip' => 'nullable|ip',
            'latitude' => 'nullable|float',
            'longitude' => 'nullable|float'
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
            'user_id' => trans('user::models.userAuth.user_id'),
            'os' => trans('user::models.userAuth.os'),
            'device' => trans('user::models.userAuth.device'),
            'browser' => trans('user::models.userAuth.browser'),
            'agent' => trans('user::models.userAuth.agent'),
            'ip' => trans('user::models.userAuth.ip'),
            'latitude' => trans('user::models.userAuth.latitude'),
            'longitude' => trans('user::models.userAuth.longitude')
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
}
