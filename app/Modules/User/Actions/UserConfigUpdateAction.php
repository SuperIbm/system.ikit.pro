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
 * Обновление конфигураций пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserConfigUpdateAction extends Action
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
        if($this->getParameter("id") && $this->getParameter("school"))
        {
            $filters = [
                [
                    "table" => "users",
                    "property" => "id",
                    "operator" => "=",
                    "value" => $this->getParameter("id")
                ],
                [
                    "table" => "user_schools",
                    "property" => "school_id",
                    "operator" => "=",
                    "value" => $this->getParameter("school")
                ]
            ];

            $user = $this->_user->get(null, null, $filters);

            if(!$this->_user->hasError())
            {
                if($user)
                {
                    $this->_user->setFlags($this->getParameter("id"), $this->getParameter("data"));

                    return true;
                }
                else
                {
                    $this->addError("user", trans('access::http.actions.userConfigUpdateAction.not_exist_user'));

                    return false;
                }
            }
            else
            {
                $this->setErrors($this->_user->getErrors());

                return false;
            }
        }
        else return null;
    }
}
