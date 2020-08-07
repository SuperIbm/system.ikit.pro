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

use Hash;
use App\Models\Action;
use App\Modules\User\Repositories\User;
use App\Modules\Access\Emails\Reset;
use Mail;

/**
 * Изменение пароля пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessPasswordAction extends Action
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
        $user = $this->getParameter("user");

        if($user)
        {
            $user = $this->_user->get($user["id"], true);

            if($user)
            {
                $check = Hash::check($this->getParameter("password_current"), $user["password"]);

                if($check)
                {
                    $status = $this->_user->update($user["id"], [
                        "password" => bcrypt($this->getParameter("password"))
                    ]);

                    if($status) return true;
                    else
                    {
                        $this->setErrors($this->_user->getErrors());

                        return false;
                    }
                }
                else
                {
                    $this->addError("access", trans('access::actions.accessPasswordAction.password_not_match'));

                    return false;
                }
            }
            else
            {
                $this->addError("user", trans('access::actions.accessPasswordAction.not_exist_user'));

                return false;
            }
        }
        else
        {
            $this->addError("user", trans('access::actions.accessPasswordAction.not_exist_user'));

            return false;
        }
    }
}
