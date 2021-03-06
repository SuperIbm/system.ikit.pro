<?php
/**
 * Модуль API аутентификации.
 * Этот модуль содержит все классы для работы с API аутентификации.
 *
 * @package App\Modules\OAuth
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\OAuth\Models;

use Eloquent;
use App\Models\Validate;
use App\Modules\User\Models\User;
use App\Models\Delete;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс модель для аунтификации через API для хранения клиентов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID клиента.
 * @property int $user_id ID пользователя.
 * @property string $secret Секрет.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\User[] $tokens
 *
 * @property-read \App\Modules\User\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthClientEloquent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthClientEloquent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthClientEloquent whereSecret($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthClientEloquent whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthClientEloquent whereUserId($value)
 *
 * @mixin \Eloquent
 */
class OAuthClientEloquent extends Eloquent
{
    use Validate, Delete;

    /**
     * Название таблицы базы данных.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    protected $table = "oauth_clients";

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
        'secret',
        'expires_at'
    ];

    /**
     * Атрибуты, которые должны быть преобразованы к дате.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    protected $dates = [
        'expires_at'
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
            'secret' => 'required|between:1,500|unique:oauth_clients,secret,' . $this->id . ',id',
            'expires_at' => 'required|date'
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
            'user_id' => trans('oauth::models.oAuthClient.user_id'),
            'secret' => trans('oauth::models.oAuthClient.secret'),
            'expires_at' => trans('oauth::models.oAuthClient.expires_at')
        ];
    }

    /**
     * Получить пользователя.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\HasOne Модель пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    /**
     * Получить токены.
     *
     * @return \App\Modules\OAuth\Models\OAuthTokenEloquent|\Illuminate\Database\Eloquent\Relations\HasMany Модель токена.
     * @version 1.0
     * @since 1.0
     */
    public function tokens(): HasMany
    {
        return $this->hasMany(OAuthTokenEloquent::class, "id", "oauth_client_id");
    }
}
