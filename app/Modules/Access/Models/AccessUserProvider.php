<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Models;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Contracts\Auth\Authenticatable as UserContract;
use App\Modules\User\Repositories\User as UserRepository;
use App\Modules\User\Repositories\BlockIp as BlockIpRepository;
use Request as RequestHelp;

/**
 * Класс драйвер для проверки аунтификации.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessUserProvider implements UserProvider
{
    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private $_user;

    /**
     * Репозитарий заблокированных IP адресов.
     *
     * @var \App\Modules\User\Repositories\BlockIp
     * @version 1.0
     * @since 1.0
     */
    private $_blockIp;


    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий для таблицы пользователей.
     * @param \App\Modules\User\Repositories\BlockIp $blockIp Репозитарий для таблицы блокированных IP.
     *
     * @version 1.0
     * @since 1.0
     */
    public function __construct(UserRepository $user, BlockIpRepository $blockIp)
    {
        $this->_user = $user;
        $this->_blockIp = $blockIp;
    }

    /**
     * Возвращение пользователя по его уникальному индификатору
     *
     * @param mixed $identifier ID пользователя.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|Object|\Eloquent|null
     * @version 1.0
     * @since 1.0
     */
    public function retrieveById($identifier)
    {
        $user = $this->_user->get($identifier);

        if($user) return $this->_user->newInstance($user, true);
        else return null;
    }

    /**
     * Возвращение пользователя через уникальный индификатор и токен помнить меня.
     *
     * @param mixed $identifier ID пользователя.
     * @param string $token Токен.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|Object|\Eloquent|null
     * @version 1.0
     * @since 1.0
     */
    public function retrieveByToken($identifier, $token)
    {
        $user = $this->_user->read([
            [
                'property' => $this->_user->getAuthIdentifierName(),
                'value' => $identifier
            ],
            [
                'property' => $this->_user->getRememberTokenName(),
                'value' => $token
            ]
        ], true);

        if($user) return $this->_user->newInstance($user[0], true);
        else return null;
    }

    /**
     * Обновление токена "запомнить меня" через указание пользователя.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param string $token Токен.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function updateRememberToken(UserContract $user, $token)
    {
        $user->setRememberToken($token);
        $user->save();
    }


    /**
     * Возвращение пользователя по заданным параметрам.
     *
     * @param array $credentials Параметры.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|Object|\Eloquent|null
     * @version 1.0
     * @since 1.0
     */
    public function retrieveByCredentials(array $credentials)
    {
        if(empty($credentials)) return null;

        $where = [];

        foreach($credentials as $key => $value)
        {
            if(!Str::contains($key, 'password'))
            {
                $where[] = [
                    'property' => $key,
                    'value' => $value
                ];
            }
        }

        $user = $this->_user->read($where);

        if($user) return $this->_user->newInstance($user[0], true);
        else return null;
    }


    /**
     * Сравнение пользователя по заданным параметрам.
     *
     * @param \Illuminate\Contracts\Auth\Authenticatable $user
     * @param array $credentials
     *
     * @return bool Вернет true если есть совпадение.
     * @version 1.0
     * @since 1.0
     */
    public function validateCredentials(UserContract $user, array $credentials)
    {
        $blockIps = $this->_blockIp->read([], true);

        if($blockIps)
        {
            for($i = 0; $i < count($blockIps); $i++)
            {
                $pattern = str_replace("*", "[0-9]{1,3}", $blockIps[$i]["ip"]);
                $pattern = "/^" . $pattern . "$/";

                if(preg_match($pattern, RequestHelp::ip(), $matches)) return false;
            }
        }

        return $credentials['password'] == $user->getAuthPassword();
    }
}
