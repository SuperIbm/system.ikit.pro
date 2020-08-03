<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Pipes\SignUp;

use Config;
use Closure;
use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserWallet;

/**
 * Регистрация нового пользователя: создание кошелька.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class WalletPipe implements Pipe
{
    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private User $_user;

    /**
     * Репозитарий кошельков пользователя.
     *
     * @var \App\Modules\User\Repositories\UserWallet
     * @version 1.0
     * @since 1.0
     */
    private UserWallet $_userWallet;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserWallet $userWallet Репозитарий кошельков пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserWallet $userWallet)
    {
        $this->_user = $user;
        $this->_userWallet = $userWallet;
    }

    /**
     * Метод который будет вызван у pipeline.
     *
     * @param array $content Содержит массив свойств, которые можно передавать от pipe к pipe.
     * @param Closure $next Ссылка на следующий pipe.
     *
     * @return mixed Вернет значение полученное после выполнения следующего pipe.
     */
    public function handle(array $content, Closure $next)
    {
        $this->_userWallet->create([
            'user_id' => $content["id"],
            'amount' => 0,
            'currency' => Config::get("currency.item")
        ]);

        if(!$this->_userWallet->hasError()) return $next($content);
        else
        {
            $this->_user->destroy($content["id"]);

            /**
             * @var $decorator \App\Models\Decorator
             */
            $decorator = $content["decorator"];
            $decorator->setErrors($this->_userWallet->getErrors());

            return false;
        }
    }
}
