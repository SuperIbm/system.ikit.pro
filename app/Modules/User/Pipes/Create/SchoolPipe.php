<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\User\Pipes\Create;

use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserSchool;
use Closure;

/**
 * Регистрация нового пользователя: добавление пользователя к школе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolPipe implements Pipe
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
     * Репозитарий школы пользователя.
     *
     * @var \App\Modules\User\Repositories\UserSchool
     * @version 1.0
     * @since 1.0
     */
    private UserSchool $_userSchool;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserSchool $userSchool Репозитарий школы пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserSchool $userSchool)
    {
        $this->_user = $user;
        $this->_userSchool = $userSchool;
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
        $this->_userSchool->create([
            "user_id" => $content["id"],
            "school_id" => $content["school"],
            "status" => true
        ]);

        if(!$this->_userSchool->hasError()) return $next($content);
        else
        {
            /**
             * @var $decorator \App\Models\Decorator
             */
            $decorator = $content["decorator"];
            $decorator->setErrors($this->_userSchool->getErrors());

            $this->_user->destroy($content["id"]);

            return false;
        }
    }
}
