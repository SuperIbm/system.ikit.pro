<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\User\Pipes\Update;

use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\User;
use Closure;

/**
 * Обновление пользователя: обновление пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UpdatePipe implements Pipe
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
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user)
    {
        $this->_user = $user;
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
        $user = $this->_user->get($content["id"]);

        if($user)
        {
            $this->_user->update($content["id"], $content["user"]);

            if(!$this->_user->hasError()) return $next($content);
            else
            {
                /**
                 * @var $decorator \App\Models\Decorator
                 */
                $decorator = $content["decorator"];
                $decorator->setErrors($this->_user->getErrors());

                return false;
            }
        }
        else
        {
            /**
             * @var $decorator \App\Models\Decorator
             */
            $decorator = $content["decorator"];
            $decorator->addError("user", trans('access::http.pipes.updatePipe.not_exist_user'));

            return false;
        }
    }
}
