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
use App\Modules\User\Decorators\UserCreateDecorator;
use App\Modules\User\Pipes\Create\CreatePipe;
use App\Modules\User\Pipes\Create\ImagePipe;
use App\Modules\User\Pipes\Create\SchoolPipe;
use App\Modules\User\Pipes\Create\AddressPipe;
use App\Modules\User\Pipes\Create\RolePipe;
use App\Modules\User\Repositories\User;

/**
 * Обновление пароля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserPasswordAction extends Action
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
        if($this->getParameter("id"))
        {
            $this->_user->update($this->getParameter("id"), [
                "password" => bcrypt($this->getParameter("password"))
            ]);

            if(!$this->_user->hasError()) return true;
            else
            {
                $this->setErrors($this->_user->getErrors());
                return false;
            }
        }
        else
        {
            $this->addError("user", "The user doesn't exist");

            return false;
        }
    }
}
