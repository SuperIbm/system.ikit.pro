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

use App\Models\Action;
use App\Modules\User\Repositories\User;

/**
 * Проверка кода на изменение пароля пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessCheckCodeResetPasswordAction extends Action
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
     * Метод запуска логики.
     *
     * @return mixed Вернет результаты исполнения.
     * @since 1.0
     * @version 1.0
     */
    public function run()
    {
        $user = $this->_user->get($this->getParameter("id"), true, [
            "recovery"
        ]);

        if($user)
        {
            if($user["recovery"] && $user["recovery"]["code"] == $this->getParameter("code"))
            {
                return true;
            }
            else
            {
                $this->addError("user", trans('access::actions.accessCheckCodeResetPasswordAction.code_not_correct'));

                return false;
            }
        }
        else
        {
            $this->addError("user", trans('access::actions.accessCheckCodeResetPasswordAction.not_exist_user'));

            return false;
        }
    }
}
