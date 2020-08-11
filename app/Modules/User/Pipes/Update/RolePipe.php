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
use App\Modules\User\Repositories\UserSchoolRole;

/**
 * Обновление пользователя: добавление ролей к пользователю.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class RolePipe implements Pipe
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
     * Репозитарий ролей школы пользователя.
     *
     * @var \App\Modules\User\Repositories\UserSchoolRole
     * @version 1.0
     * @since 1.0
     */
    private UserSchoolRole $_userSchoolRole;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserSchoolRole $userSchoolRole Репозитарий ролей школы пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserSchoolRole $userSchoolRole)
    {
        $this->_user = $user;
        $this->_userSchoolRole = $userSchoolRole;
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
        if($content["roles"])
        {
            $filters = [
                [
                    "property" => "id",
                    "operator" => "=",
                    "value" => $content["id"],
                    "logic" => "and"
                ],
                [
                    "table" => "user_schools",
                    "property" => "school_id",
                    "operator" => "=",
                    "value" => $content["school"],
                    "logic" => "and"
                ]
            ];

            $user = $this->_user->get(null, null, $filters, [
                "schools.roles"
            ]);

            if(!$this->_user->getError())
            {
                if($user)
                {

                }

                exit;

                $this->_userSchoolRole->destroy(null, );

                for($i = 0; $i < count($content["roles"]); $i++)
                {
                    $this->_userSchoolRole->create([
                        "user_id" => $content["id"],
                        "school_role_id" => $content["roles"][$i]
                    ]);

                    if($this->_userSchoolRole->hasError())
                    {
                        /**
                         * @var $decorator \App\Models\Decorator
                         */
                        $decorator = $content["decorator"];
                        $decorator->setErrors($this->_userSchoolRole->getErrors());

                        $this->_user->destroy($content["id"]);

                        return false;
                    }
                }

                return $next($content);
            }




        }
        else return $next($content);
    }
}
