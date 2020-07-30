<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Actions;

use Mail;
use App\Models\Action;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserRecovery;
use App\Modules\Access\Emails\Reset;

/**
 * Изменение пароля пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessResetAction extends Action
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
     * Репозитарий восстановления пароля пользователя.
     *
     * @var \App\Modules\User\Repositories\UserRecovery
     * @version 1.0
     * @since 1.0
     */
    private $_userRecovery;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserRecovery $userRecovery Репозитарий восстановления пароля пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserRecovery $userRecovery)
    {
        $this->_user = $user;
        $this->_userRecovery = $userRecovery;
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
        $action = app(AccessCheckCodeResetPasswordAction::class);

        $status = $action->setParameters([
            "id" => $this->getParameter("id"),
            "code" => $this->getParameter("code")
        ])->run();

        if($status)
        {
            $user = $this->_user->get($this->getParameter("id"), true, [
                "recovery"
            ]);

            if($user)
            {
                $status = $this->_user->update($user["id"], [
                    "password" => bcrypt($this->getParameter("password"))
                ]);

                if($status)
                {
                    if($user["recovery"]) $this->_userRecovery->destroy($user["recovery"]["id"]);

                    $data = [
                        "name" => $user["first_name"] . " " . $user["second_name"]
                    ];

                    Mail::to($user["login"])->send(new Reset($data));

                    return true;
                }
                else
                {
                    $this->setErrors($this->_user->getErrors());

                    return false;
                }
            }
            else
            {
                $this->addError("user", "The user doesn't exist or not find it.");

                return false;
            }
        }
        else
        {
            $this->setErrors($action->getErrors());

            return false;
        }
    }
}
