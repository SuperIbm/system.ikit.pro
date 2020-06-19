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
        'user_id',
        "postal_code",
        "country",
        "country_name",
        "region",
        "region_name",
        "city",
        "street_address",
        "latitude",
        "longitude"
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
            "user_id" => 'required|integer|digits_between:1,20',
            'postal_code' => 'max:10',
            'country' => 'max:191',
            'country_name' => 'max:191',
            'region' => 'max:191',
            'region_name' => 'max:191',
            'city' => 'max:191',
            'street_address' => 'max:191',
            'latitude' => 'float',
            'longitude' => 'float'
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
            "user_id" => 'ID user',
            'postal_code' => 'Postal code',
            'country' => 'Country code',
            'country_name' => 'Country',
            'region' => 'Region code',
            'region_name' => 'Region',
            'city' => 'City',
            'street_address' => 'Street address',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude'
        ];
    }

    /**
     * Получить запись выбранных групп.
     *
     * @return \App\Modules\User\Models\User[]|\Illuminate\Database\Eloquent\Relations\HasOne Модель пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}