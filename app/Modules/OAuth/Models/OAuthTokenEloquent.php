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
use App\Models\Delete;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Класс модель для аунтификации через API для хранения токенов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID токена.
 * @property int $oauth_client_id ID клиента.
 * @property string $token Токен.
 *
 * @property-read \App\Modules\OAuth\Models\OAuthClientEloquent $client
 * @property-read \App\Modules\OAuth\Models\OAuthRefreshTokenEloquent $refreshToken
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthTokenEloquent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthTokenEloquent whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthTokenEloquent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthTokenEloquent whereOauthClientId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthTokenEloquent whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthTokenEloquent whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class OAuthTokenEloquent extends Eloquent
{
    use Validate, Delete;

    /**
     * Название таблицы базы данных.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    protected $table = "oauth_tokens";

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'oauth_client_id',
        'token',
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
            'oauth_client_id' => 'required|integer|digits_between:1,20',
            'token' => 'required|between:1,500|unique:oauth_tokens,token,' . $this->id . ',id',
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
            'oauth_client_id' => trans('oauth::models.OAuthToken.oauth_client_id'),
            'token' => trans('oauth::models.OAuthToken.token'),
            'expires_at' => trans('oauth::models.OAuthToken.expires_at')
        ];
    }

    /**
     * Получить клиента.
     *
     * @return \App\Modules\OAuth\Models\OAuthClientEloquent|\Illuminate\Database\Eloquent\Relations\HasOne Модель пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function client(): HasOne
    {
        return $this->hasOne(OAuthClientEloquent::class, "id", "oauth_client_id");
    }

    /**
     * Получить клиента.
     *
     * @return \App\Modules\OAuth\Models\OAuthRefreshTokenEloquent|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function refreshToken(): BelongsTo
    {
        return $this->belongsTo(OAuthRefreshTokenEloquent::class);
    }
}
