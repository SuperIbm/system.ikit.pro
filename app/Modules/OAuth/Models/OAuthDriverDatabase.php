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

use App\Modules\User\Repositories\User;
use App\Modules\OAuth\Contracts\OAuthDriver;
use App\Modules\OAuth\Repositories\OAuthClientEloquent;
use App\Modules\OAuth\Repositories\OAuthTokenEloquent;
use App\Modules\OAuth\Repositories\OAuthRefreshTokenEloquent;
use Carbon\Carbon;
use Config;

/**
 * Класс драйвер работы с токенами в базе данных.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OAuthDriverDatabase extends OAuthDriver
{
    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    protected User $_user;

    /**
     * Репозитарий клиентов.
     *
     * @var \App\Modules\OAuth\Repositories\OAuthClientEloquent
     * @version 1.0
     * @since 1.0
     */
    protected OAuthClientEloquent $_oAuthClientEloquent;

    /**
     * Репозитарий токентов.
     *
     * @var \App\Modules\OAuth\Repositories\OAuthTokenEloquent
     * @version 1.0
     * @since 1.0
     */
    protected OAuthTokenEloquent $_oAuthTokenEloquent;

    /**
     * Репозитарий токентов обновления.
     *
     * @var \App\Modules\OAuth\Repositories\OAuthRefreshTokenEloquent
     * @version 1.0
     * @since 1.0
     */
    protected OAuthRefreshTokenEloquent $_oAuthRefreshTokenEloquent;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\OAuth\Repositories\OAuthClientEloquent $oAuthClientEloquent Репозитарий клиентов.
     * @param \App\Modules\OAuth\Repositories\OAuthTokenEloquent $oAuthTokenEloquent Репозитарий токентов.
     * @param \App\Modules\OAuth\Repositories\OAuthRefreshTokenEloquent $oAuthRefreshTokenEloquent Репозитарий токентов обновления.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, OAuthClientEloquent $oAuthClientEloquent, OAuthTokenEloquent $oAuthTokenEloquent, OAuthRefreshTokenEloquent $oAuthRefreshTokenEloquent)
    {
        $this->_user = $user;
        $this->_oAuthClientEloquent = $oAuthClientEloquent;
        $this->_oAuthTokenEloquent = $oAuthTokenEloquent;
        $this->_oAuthRefreshTokenEloquent = $oAuthRefreshTokenEloquent;
    }

    /**
     * Абстрактный метод создания секретного ключа.
     *
     * @param int $userId ID пользователя.
     *
     * @return string|bool Вернет секретный ключ клиента.
     * @since 1.0
     * @version 1.0
     */
    public function secret(int $userId)
    {
        $expiresAtToken = Carbon::now()->addSeconds(Config::get("token.secret_life"));
        $expiresAtRefreshToken = Carbon::now()->addSeconds(Config::get("token.refresh_token_life"));
        $issue = $this->issue([
            "user" => $userId
        ], $expiresAtToken, $expiresAtRefreshToken);

        $this->_oAuthClientEloquent->create([
            'user_id' => $userId,
            'secret' => $issue["accessToken"],
            'expires_at' => $expiresAtToken
        ]);

        if(!$this->_oAuthClientEloquent->hasError()) return $issue["accessToken"];
        else
        {
            $this->setErrors($this->_oAuthClientEloquent->getErrors());

            return false;
        }
    }

    /**
     * Абстрактный метод получения токена.
     *
     * @param string $secret Секретный ключ клиента.
     *
     * @return array|bool Вернет массив в котором будем ключ и ключ обновления.
     * @since 1.0
     * @version 1.0
     */
    public function token(string $secret)
    {
        $data = $this->decode($secret, "accessToken");

        if($data)
        {
            $user = $this->_user->get($data["user"], true);

            if(!$this->_user->hasError())
            {
                if($user)
                {
                    $filter = [
                        [
                            'table' => 'oauth_clients',
                            'property' => 'secret',
                            'value' => $secret
                        ],
                        [
                            'table' => 'oauth_clients',
                            'property' => 'user_id',
                            'value' => $data["user"]
                        ]
                    ];

                    $client = $this->_oAuthClientEloquent->get(null, $filter);

                    if(!$this->_oAuthClientEloquent->hasError())
                    {
                        if($client)
                        {
                            $expiresAtToken = Carbon::now()->addSeconds(Config::get("token.token_life"));
                            $expiresAtRefreshToken = Carbon::now()->addSeconds(Config::get("token.refresh_token_life"));

                            $issue = $this->issue([
                                "user" => $data["user"],
                                "client" => $client["id"]
                            ], $expiresAtToken, $expiresAtRefreshToken);

                            $token = $this->_oAuthTokenEloquent->create([
                                'oauth_client_id' => $client["id"],
                                'token' => $issue["accessToken"],
                                'expires_at' => $expiresAtToken
                            ]);

                            if(!$this->_oAuthTokenEloquent->hasError())
                            {
                                $this->_oAuthRefreshTokenEloquent->create([
                                    'oauth_token_id' => $token,
                                    'refresh_token' => $issue["refreshToken"],
                                    'expires_at' => $expiresAtRefreshToken
                                ]);

                                if(!$this->_oAuthRefreshTokenEloquent->hasError()) return $issue;
                                else
                                {
                                    $this->setErrors($this->_oAuthRefreshTokenEloquent->getErrors());

                                    return false;
                                }
                            }
                            else
                            {
                                $this->setErrors($this->_oAuthTokenEloquent->getErrors());

                                return false;
                            }
                        }
                        else
                        {
                            $this->addError("client", "The client doesn't find.");

                            return false;
                        }
                    }
                    else
                    {
                        $this->setErrors($this->_oAuthClientEloquent->getErrors());

                        return false;
                    }
                }
                else
                {
                    $this->addError("user", "The user doesn't exist");

                    return false;
                }
            }
            else
            {
                $this->setErrors($this->_user->getErrors());

                return false;
            }
        }
        else
        {
            $this->addError("secret", "The secret code is not valid.");

            return false;
        }
    }

    /**
     * Абстрактный метод обновления токена.
     *
     * @param string $refreshToken Токен обновления.
     *
     * @return array|bool Вернет массив в котором будет токен и ключ обновления.
     * @since 1.0
     * @version 1.0
     */
    public function refresh(string $refreshToken)
    {
        $data = $this->decode($refreshToken, "refreshToken");

        if($data)
        {
            $user = $this->_user->get($data["user"], true);

            if(!$this->_user->hasError())
            {
                if($user)
                {
                    $client = $this->_oAuthClientEloquent->get($data["client"]);

                    if(!$this->_oAuthClientEloquent->hasError())
                    {
                        if($client)
                        {
                            $filter = [
                                [
                                    'table' => 'oauth_refresh_tokens',
                                    'property' => 'refresh_token',
                                    'value' => $refreshToken
                                ],
                                [
                                    'table' => 'oauth_clients',
                                    'property' => 'user_id',
                                    'value' => $data["user"]
                                ]
                            ];

                            $record = $this->_oAuthRefreshTokenEloquent->get(null, $filter, [
                                "token.client"
                            ]);

                            if(!$this->_oAuthRefreshTokenEloquent->hasError())
                            {
                                if($record)
                                {
                                    $expiresAtToken = Carbon::now()->addSeconds(Config::get("token.token_life"));
                                    $expiresAtRefreshToken = Carbon::now()
                                        ->addSeconds(Config::get("token.refresh_token_life"));

                                    $issue = $this->issue([
                                        "user" => $data["user"],
                                        "client" => $client["id"]
                                    ], $expiresAtToken, $expiresAtRefreshToken);

                                    $token = $this->_oAuthTokenEloquent->get(null, [
                                        [
                                            'table' => 'oauth_tokens',
                                            'property' => 'token',
                                            'value' => $issue["accessToken"]
                                        ]
                                    ]);

                                    if($token)
                                    {
                                        $token = $this->_oAuthTokenEloquent->update($token["id"], [
                                            'oauth_client_id' => $client["id"],
                                            'expires_at' => $expiresAtToken
                                        ]);
                                    }
                                    else
                                    {
                                        $token = $this->_oAuthTokenEloquent->create([
                                            'oauth_client_id' => $client["id"],
                                            'token' => $issue["accessToken"],
                                            'expires_at' => $expiresAtToken
                                        ]);
                                    }

                                    if(!$this->_oAuthTokenEloquent->hasError())
                                    {
                                        $this->_oAuthRefreshTokenEloquent->create([
                                            'oauth_token_id' => $token,
                                            'refresh_token' => $issue["refreshToken"],
                                            'expires_at' => $expiresAtRefreshToken
                                        ]);

                                        if(!$this->_oAuthRefreshTokenEloquent->hasError()) return $issue;
                                        else
                                        {
                                            $this->setErrors($this->_oAuthRefreshTokenEloquent->getErrors());

                                            return false;
                                        }
                                    }
                                    else
                                    {
                                        $this->setErrors($this->_oAuthTokenEloquent->getErrors());

                                        return false;
                                    }
                                }
                                else
                                {
                                    $this->addError("refreshToke", "The refresh token doesn't exist");

                                    return false;
                                }
                            }
                            else
                            {
                                $this->setErrors($this->_oAuthTokenEloquent->getErrors());

                                return false;
                            }
                        }
                        else
                        {
                            $this->addError("client", "The client doesn't exist.");

                            return false;
                        }
                    }
                    else
                    {
                        $this->setErrors($this->_oAuthClientEloquent->getErrors());

                        return false;
                    }
                }
                else
                {
                    $this->addError("user", "The user doesn't exist.");

                    return false;
                }
            }
            else
            {
                $this->setErrors($this->_user->getErrors());

                return false;
            }
        }
        else
        {
            $this->addError("secret", "The token is not valid.");

            return false;
        }
    }

    /**
     * Проверка токена.
     *
     * @param string $token Токен.
     *
     * @return bool Вернет результат проверки.
     * @since 1.0
     * @version 1.0
     */
    public function check(string $token)
    {
        $data = $this->decode($token, "accessToken");

        if($data)
        {
            $user = $this->_user->get($data["user"], true);

            if(!$this->_user->hasError())
            {
                if($user)
                {
                    $client = $this->_oAuthClientEloquent->get($data["client"]);

                    if(!$this->_oAuthClientEloquent->hasError())
                    {
                        if($client)
                        {
                            $filter = [
                                [
                                    'table' => 'oauth_tokens',
                                    'property' => 'token',
                                    'value' => $token
                                ],
                                [
                                    'table' => 'oauth_clients',
                                    'property' => 'user_id',
                                    'value' => $data["user"]
                                ]
                            ];

                            $record = $this->_oAuthTokenEloquent->get(null, $filter, [
                                "client"
                            ]);

                            if(!$this->_oAuthTokenEloquent->hasError())
                            {
                                if($record) return true;
                                else return false;
                            }
                            else
                            {
                                $this->setErrors($this->_oAuthTokenEloquent->getErrors());

                                return false;
                            }
                        }
                        else
                        {
                            $this->addError("client", "The client doesn't exist.");

                            return false;
                        }
                    }
                    else
                    {
                        $this->setErrors($this->_oAuthClientEloquent->getErrors());

                        return false;
                    }
                }
                else
                {
                    $this->addError("user", "The user doesn't exist.");

                    return false;
                }
            }
            else
            {
                $this->setErrors($this->_user->getErrors());

                return false;
            }
        }
        else
        {
            $this->addError("secret", "The token is not valid.");

            return false;
        }
    }

    /**
     * Очитска системы от старых токенов.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function clean(): void
    {
        $filter = [
            [
                'table' => 'oauth_clients',
                'property' => 'expires_at',
                "operator" => "<=",
                'value' => Carbon::now()
            ]
        ];

        $clients = $this->_oAuthClientEloquent->read($filter);

        if($clients)
        {
            $ids = collect($clients)->pluck("id")->toArray();
            $this->_oAuthClientEloquent->destroy($ids, true);
        }

        //

        $filter = [
            [
                'table' => 'oauth_tokens',
                'property' => 'expires_at',
                "operator" => "<=",
                'value' => Carbon::now()
            ]
        ];

        $tokens = $this->_oAuthTokenEloquent->read($filter);

        if($tokens)
        {
            $ids = collect($tokens)->pluck("id")->toArray();
            $this->_oAuthTokenEloquent->destroy($ids, true);
        }
    }
}

