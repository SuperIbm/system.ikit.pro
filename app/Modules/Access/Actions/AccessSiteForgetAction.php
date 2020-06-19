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

use Crypt;
use Carbon\Carbon;
use App\Models\Action;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserRecovery;
use Mail;
use App\Modules\Access\Emails\Recovery;

/**
 * Отправки email для восстанрвоения пароля
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSiteForgetAction extends Action
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
        $users = $this->_user->read([
            [
                'property' => "login",
                'value' => $this->getParameter("login")
            ]
        ], true);

        if($users)
        {
            $user = $users[0];
            $code = Crypt::encrypt(intval(Carbon::now()->format("U")) + rand(1000000, 100000000));

            $recovery = $this->_userRecovery->read([
                [
                    'property' => "user_id",
                    'value' => $user["id"]
                ]
            ]);

            if($recovery)
            {
                $this->_userRecovery->update($recovery[0]["id"], [
                    "code" => $code
                ]);
            }
            else
            {
                $this->_userRecovery->create([
                    "user_id" => $user["id"],
                    "code" => $code
                ]);
            }

            $data = [
                "id" => $user["id"],
                "code" => $code
            ];

            Mail::to($user["login"])->send(new Recovery($data));

            return true;
        }
        else
        {
            $this->addError("user", "The user doesn't exist or not find it.");
            return false;
        }
    }
}
