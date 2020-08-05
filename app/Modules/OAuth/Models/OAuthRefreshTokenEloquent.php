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

/**
 * Класс модель для аунтификации через API для хранения токенов обновления на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID токена на обновления.
 * @property int $oauth_token_id ID токена.
 * @property string $refresh_token Токен обновления.
 *
 * @property-read \App\Modules\OAuth\Models\OAuthTokenEloquent $token
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthRefreshTokenEloquent whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthRefreshTokenEloquent whereExpiresAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthRefreshTokenEloquent whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthRefreshTokenEloquent whereOauthTokenId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthRefreshTokenEloquent whereRefreshToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\OAuth\Models\OAuthRefreshTokenEloquent whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
class OAuthRefreshTokenEloquent extends Eloquent
{
    use Validate, Delete;

    /**
     * Название таблицы базы данных.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    protected $table = "oauth_refresh_tokens";

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'oauth_token_id',
        'refresh_token',
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
            'oauth_token_id' => 'required|integer|digits_between:1,20',
            'refresh_token' => 'required|between:1,500',
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
            'oauth_token_id' => trans('oauth::models.OAuthRefreshToken.oauth_token_id'),
            'refresh_token' => trans('oauth::models.OAuthRefreshToken.refresh_token'),
            'expires_at' => trans('oauth::models.OAuthRefreshToken.expires_at')
        ];
    }

    /**
     * Получить токен.
     *
     * @return \App\Modules\OAuth\Models\OAuthTokenEloquent|\Illuminate\Database\Eloquent\Relations\HasOne Модель токенов.
     * @version 1.0
     * @since 1.0
     */
    public function token(): HasOne
    {
        return $this->hasOne(OAuthTokenEloquent::class, "id", "oauth_token_id");
    }
}
