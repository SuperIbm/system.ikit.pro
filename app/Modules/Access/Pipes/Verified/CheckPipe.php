<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Pipes\Verified;

use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserVerification;
use Closure;

/**
 * Верификация пользователя: верефицируем пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CheckPipe implements Pipe
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
     * Репозитарий верификации пользователя.
     *
     * @var \App\Modules\User\Repositories\UserVerification
     * @version 1.0
     * @since 1.0
     */
    private $_userVerification;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserVerification $userVerification Репозитарий верификации пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserVerification $userVerification)
    {
        $this->_user = $user;
        $this->_userVerification = $userVerification;
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
        $user = $this->_user->get($content["id"], true);

        if($user)
        {
            $verification = $this->_userVerification->get(null, null, [
                [
                    'property' => "user_id",
                    'value' => $content["id"]
                ]
            ]);

            if($verification)
            {
                if($verification["code"] == $content["code"])
                {
                    if($verification["status"] == false)
                    {
                        $this->_userVerification->update($verification["id"], [
                            'status' => true
                        ]);

                        return $next($content);
                    }
                    else
                    {
                        /**
                         * @var $decorator \App\Models\Decorator
                         */
                        $decorator = $content["decorator"];
                        $decorator->addError("user", trans('access::pipes.verified.checkPipe.user_is_verified'));

                        return false;
                    }
                }
                else
                {
                    /**
                     * @var $decorator \App\Models\Decorator
                     */
                    $decorator = $content["decorator"];
                    $decorator->addError("user", trans('access::pipes.verified.checkPipe.not_correct_code'));

                    return false;
                }
            }
            else
            {
                /**
                 * @var $decorator \App\Models\Decorator
                 */
                $decorator = $content["decorator"];
                $decorator->addError("user", trans('access::pipes.verified.checkPipe.not_exist_code'));

                return false;
            }
        }
        else
        {
            /**
             * @var $decorator \App\Models\Decorator
             */
            $decorator = $content["decorator"];
            $decorator->addError("user", trans('access::pipes.verified.checkPipe.not_exist_user'));

            return false;
        }
    }
}
