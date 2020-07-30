<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Order\Pipes\SignUp;

use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\User;
use Closure;

/**
 * Регистрация нового пользователя: создание пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CreatePipe implements Pipe
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
        $data = [
            "login" => $content["user"]["login"],
            "password" => bcrypt($content["user"]["password"]),
            "first_name" => $content["user"]["first_name"],
            "second_name" => $content["user"]["second_name"],
            "telephone" => $content["user"]["telephone"],
            "status" => true
        ];

        $id = $this->_user->create($data);

        if($id)
        {
            $content["id"] = $id;

            return $next($content);
        }
        else
        {
            /**
             * @var $entity \App\Models\Decorator
             */
            $entity = $content["entity"];
            $entity->setErrors($this->_user->getErrors());

            return false;
        }
    }
}
