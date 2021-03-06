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
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Класс модель для таблицы адресов пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class UserAddress extends Eloquent
{
    use Validate, SoftDeletes, Status, Delete;

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
        "postal_code",
        "country",
        "region",
        "city",
        "street_address",
        "latitude",
        "longitude"
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
            "user_id" => 'required|integer|digits_between:1,20',
            'postal_code' => 'max:10',
            'country' => 'max:191',
            'region' => 'max:191',
            'city' => 'max:191',
            'street_address' => 'max:191',
            'latitude' => 'float',
            'longitude' => 'float'
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
            "user_id" => trans('user::models.userAddress.user_id'),
            'postal_code' => trans('user::models.userAddress.postal_code'),
            'country' => trans('user::models.userAddress.country'),
            'region' => trans('user::models.userAddress.region'),
            'city' => trans('user::models.userAddress.city'),
            'street_address' => trans('user::models.userAddress.street_address'),
            'latitude' => trans('user::models.userAddress.latitude'),
            'longitude' => trans('user::models.userAddress.longitude')
        ];
    }

    /**
     * Получить пользователя.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\HasOne Модель пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}
