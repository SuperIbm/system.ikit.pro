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
use App\Modules\Access\Emails\Verification;

/**
 * Отправка e-mail сообщения с кодом верификации.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSendEmailVerificationCodeAction extends Action
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
        $user = $this->_user->get($this->getParameter("id"), true, null, [
            "verification"
        ]);

        if($user)
        {
            $data = [
                "id" => $user["id"],
                "code" => $user["verification"]["code"]
            ];

            Mail::to($user["login"])->send(new Verification($data));

            return true;
        }
        else
        {
            $this->addError("user", trans('access::actions.accessSendEmailVerificationCodeAction.not_exist_user'));

            return false;
        }
    }
}
