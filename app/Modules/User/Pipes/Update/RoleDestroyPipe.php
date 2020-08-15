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
 * Обновление пользователя: удаление старых ролей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class RoleDestroyPipe implements Pipe
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
                    "table" => "users",
                    "property" => "id",
                    "operator" => "=",
                    "value" => $content["id"],
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
                    if($user["schools"])
                    {
                        for($i = 0; $i < count($user["schools"]); $i++)
                        {
                            if($user["schools"][$i]["school_id"] == $content["school"])
                            {
                                for($z = 0; $z < count($user["schools"][$i]["roles"]); $z++)
                                {
                                    $this->_userSchoolRole->destroy($user["schools"][$i]["roles"][$z]["id"]);

                                    if($this->_userSchoolRole->hasError())
                                    {
                                        /**
                                         * @var $decorator \App\Models\Decorator
                                         */
                                        $decorator = $content["decorator"];
                                        $decorator->setErrors($this->_userSchoolRole->getErrors());

                                        return false;
                                    }
                                }
                            }
                        }
                    }

                    return $next($content);
                }
                else
                {
                    /**
                     * @var $decorator \App\Models\Decorator
                     */
                    $decorator = $content["decorator"];
                    $decorator->addError("user", "The user does not exist.");

                    return false;
                }
            }
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
        else return $next($content);
    }
}
