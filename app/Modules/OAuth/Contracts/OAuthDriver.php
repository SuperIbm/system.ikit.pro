<?php
/**
 * Модуль API аутентификации.
 * Этот модуль содержит все классы для работы с API аутентификации.
 *
 * @package App\Modules\OAuth
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\OAuth\Contracts;

use Config;
use Carbon\Carbon;
use Firebase\JWT\JWT;
use App\Models\Error;

/**
 * Абстрактный класс позволяющий проектировать собственные классы для хранения токенов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class OAuthDriver
{
    use Error;

    /**
     * Абстрактный метод создания секретного ключа.
     *
     * @param int $userId ID пользователя.
     *
     * @return string|bool Вернет секретный ключ клиента.
     * @since 1.0
     * @version 1.0
     */
    abstract public function secret(int $userId);

    /**
     * Абстрактный метод получения токена.
     *
     * @param string $secret Секретный ключ клиента.
     *
     * @return array|bool Вернет массив в котором будем ключ и ключ обновления.
     * @since 1.0
     * @version 1.0
     */
    abstract public function token(string $secret);

    /**
     * Абстрактный метод обновления токена.
     *
     * @param string $refreshToken Токен обновления.
     *
     * @return array|bool Вернет массив в котором будет токен и ключ обновления.
     * @since 1.0
     * @version 1.0
     */
    abstract public function refresh(string $refreshToken);

    /**
     * Проверка токена.
     *
     * @param string $token Токен.
     *
     * @return bool Вернет результат проверки.
     * @since 1.0
     * @version 1.0
     */
    abstract public function check(string $token);

    /**
     * Очитска системы от старых токенов.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    abstract public function clean();

    /**
     * Выдача токена.
     *
     * @param mixed $value Значение для сохранения в токене.
     * @param \Carbon\Carbon $expiresAtToken Время жизни токена.
     * @param \Carbon\Carbon $expiresAtRefreshToken Время жизни токена обновления.
     *
     * @return array Вернет массив с токеном и токеном обновления.
     * @since 1.0
     * @version 1.0
     */
    public function issue($value, Carbon $expiresAtToken, Carbon $expiresAtRefreshToken = null): array
    {
        $key = Config::get("app.key");
        $extendToken = $expiresAtToken->format("U") - Carbon::now()->format("U");
        $extendRefreshToken = $expiresAtRefreshToken->format("U") - Carbon::now()->format("U");

        $accessToken = [
            "iss" => Config::get("app.url"),
            "aud" => Config::get("app.name"),
            "exp" => $expiresAtToken->format("U"),
            "type" => "accessToken",
            "data" => $value,
            "extend" => $extendToken
        ];

        $accessToken = JWT::encode($accessToken, $key);

        $refreshToken = [
            "iss" => Config::get("app.url"),
            "aud" => Config::get("app.name"),
            "exp" => $expiresAtRefreshToken->format("U"),
            "type" => "refreshToken",
            "data" => $value,
            "extend" => $extendRefreshToken
        ];

        $refreshToken = JWT::encode($refreshToken, $key);

        return [
            "accessToken" => $accessToken,
            "refreshToken" => $refreshToken
        ];
    }

    /**
     * Декодирование токена.
     *
     * @param string $token Токен.
     * @param string $type Тип токена.
     *
     * @return array|bool Вернет массив с токеном и токеном обновления.
     * @since 1.0
     * @version 1.0
     */
    public function decode(string $token, string $type)
    {
        $key = Config::get("app.key");

        try
        {
            $values = (array)JWT::decode($token, $key, ['HS256']);

            if($values)
            {
                if(Carbon::now()
                        ->format("U") <= $values["exp"] && $values["iss"] == Config::get("app.url") && $values["aud"] == Config::get("app.name") && $values["type"] == $type)
                {
                    return (array)$values["data"];
                }
                else
                {
                    $this->addError("token", "The token is invalid.");

                    return false;
                }
            }
            else
            {
                $this->addError("token", "The token is invalid.");

                return false;
            }
        }
        catch(\Exception $er)
        {
            $this->addError("token", $er->getMessage());

            return false;
        }
    }
}
