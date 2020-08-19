<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\User\Actions;

use App\Models\Action;
use App\Modules\User\Repositories\User;

/**
 * Чтение пользователей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserReadAction extends Action
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
     * Метод запуска логики.
     *
     * @return mixed Вернет результаты исполнения.
     * @since 1.0
     * @version 1.0
     */
    public function run()
    {
        if($this->getParameter("school"))
        {
            $filters = [
                [
                    "table" => "user_schools",
                    "property" => "school_id",
                    "operator" => "=",
                    "value" => $this->getParameter("school")
                ]
            ];

            if($this->getParameter("filter"))
            {
                $filters[] = [
                    [
                        "table" => "users",
                        "property" => "login",
                        "operator" => "like",
                        "value" => $this->getParameter("filter"),
                        "logic" => "or"
                    ],
                    [
                        "table" => "users",
                        "property" => "first_name",
                        "operator" => "like",
                        "value" => $this->getParameter("filter"),
                        "logic" => "or"
                    ],
                    [
                        "table" => "users",
                        "property" => "second_name",
                        "operator" => "like",
                        "value" => $this->getParameter("filter"),
                        "logic" => "or"
                    ],
                    [
                        "table" => "users",
                        "property" => "email",
                        "operator" => "like",
                        "value" => $this->getParameter("filter"),
                        "logic" => "or"
                    ],
                    [
                        "table" => "users",
                        "property" => "telephone",
                        "operator" => "like",
                        "value" => $this->getParameter("filter"),
                        "logic" => "or"
                    ]
                ];
            }

            $users = $this->_user->read($filters, null, $this->getParameter("sort"), $this->getParameter("start"), $this->getParameter("limit"), [
                "userAddress",
                "verification",
                "schools",
                "schoolRoles",
                "wallet",
                "referralInvited",
                "auths"
            ]);

            if(!$this->_user->hasError()) return $users;
            else
            {
                $this->setErrors($this->_user->getErrors());

                return false;
            }
        }
        else return null;
    }
}
