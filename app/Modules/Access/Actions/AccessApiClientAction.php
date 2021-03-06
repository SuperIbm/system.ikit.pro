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

use OAuth;
use App\Models\Action;
use Hash;
use App\Modules\User\Repositories\User;

/**
 * Класс действия для генерации клиента.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessApiClientAction extends Action
{
    /**
     * Репозитарий для выбранных групп пользователя.
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
        $user = $this->_user->get(null, true, [
            [
                'property' => 'login',
                'value' => $this->getParameter("login")
            ]
        ]);

        if($user)
        {
            $check = false;

            if($this->getParameter("password")) $check = Hash::check($this->getParameter("password"), $user["password"]);
            else if($this->getParameter("force")) $check = true;

            if($check)
            {
                $secret = OAuth::secret($user["id"]);

                if(!OAuth::hasError())
                {
                    unset($user["password"]);

                    return [
                        "user" => $user,
                        "secret" => $secret
                    ];
                }
                else $this->setErrors(OAuth::getErrors());
            }
            else $this->addError("access", trans('access::actions.accessApiClientAction.password_not_match'));
        }
        else $this->addError("user", trans('access::actions.accessApiClientAction.not_exist_user'));

        return false;
    }
}
