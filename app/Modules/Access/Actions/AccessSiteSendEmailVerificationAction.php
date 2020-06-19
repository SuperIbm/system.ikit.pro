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
use App\Modules\Access\Tasks\AccessSiteSendEmailVerificationTask;

/**
 * Отправка e-mail сообщения пользователю для верификации.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSiteSendEmailVerificationAction extends Action
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
        $filters = [
            [
                "property" => "login",
                "operator" => "=",
                "value" => $this->getParameter("email"),
                "logic" => "and"
            ]
        ];

        $users = $this->_user->read($filters);

        if($users)
        {
            $user = $users[0];
            $accessSiteSendEmailVerificationTask = app(AccessSiteSendEmailVerificationTask::class);

            $result = $accessSiteSendEmailVerificationTask->setParameters([
                "id" => $user["id"]
            ])->run();

            if($result) return true;
            else
            {
                $this->setErrors($accessSiteSendEmailVerificationTask->getErrors());
                return false;
            }
        }
        else
        {
            $this->addError("user", "The user doesn't exist.");
            return false;
        }
    }
}
