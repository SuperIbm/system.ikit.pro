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
use Crypt;
use Carbon\Carbon;
use App\Models\Action;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserGroupUser;
use App\Modules\User\Repositories\UserGroup;
use App\Modules\User\Repositories\UserVerification;
use App\Modules\Access\Emails\Verification;

/**
 * Верификация пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSiteVerifiedAction extends Action
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
     * Репозитарий верификации пользователя.
     *
     * @var \App\Modules\User\Repositories\UserVerification
     * @version 1.0
     * @since 1.0
     */
    private $_userVerification;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserVerification $userVerification Репозитарий верификации пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserVerification $userVerification)
    {
        $this->_user = $user;
        $this->_userVerification = $userVerification;
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
        $user = $this->_user->get($this->getParameter("id"), true);

        if($user)
        {
            $verification = $this->_userVerification->read([
                [
                    'property' => "user_id",
                    'value' => $this->getParameter("id")
                ]
            ]);

            if($verification)
            {
                $verification = $verification[0];

                if($verification["code"] == $this->getParameter("code"))
                {
                    if($verification["status"] == false)
                    {
                        $this->_userVerification->update($verification["id"], [
                            'status' => true
                        ]);

                        $gate = app(AccessGateAction::class)->setParameters([
                            "id" => $user["id"]
                        ])->run();

                        $accessApiClientAction = app(AccessApiClientAction::class);

                        $client = $accessApiClientAction->setParameters([
                            "login" => $user["login"],
                            "force" => true
                        ])->run();

                        $accessApiTokenAction = app(AccessApiTokenAction::class);

                        $token = $accessApiTokenAction->setParameters([
                            "secret" => $client["secret"]
                        ])->run();

                        return [
                            "gate" => $gate,
                            "client" => $client,
                            "token" => $token
                        ];
                    }
                    else
                    {
                        $this->addError("user", "The user has been already verified.");
                        return false;
                    }
                }
                else
                {
                    $this->addError("user", "The verification code is not correct.");
                    return false;
                }
            }
            else
            {
                $this->addError("user", "The verification code doesn't exist.");
                return false;
            }
        }
        else
        {
            $this->addError("user", "The user doesn't exist or not find it.");
            return false;
        }

        /*
        $data = [
            "login" => $this->getParameter("login"),
            "password" => $this->getParameter("password"),
            "first_name" => $this->getParameter("first_name"),
            "last_name" => $this->getParameter("last_name"),
            "company" => $this->getParameter("company"),
            "telephone" => $this->getParameter("telephone"),
            "status" => true
        ];

        $id = $this->_user->create($data);

        if($id)
        {
            $data["id"] = $id;

            $groups = $this->_userGroup->read
            (
                [
                    [
                        'property' => "name_group",
                        'value' => "User"
                    ]
                ]
            );

            if($groups)
            {
                $this->_userGroupUser->create
                (
                    [
                        "user_group_id" => $groups[0]["id"],
                        "user_id" => $id
                    ]
                );

                $data["code"] = Crypt::encrypt(intval(Carbon::now()->format("U")) + rand(1000000, 100000000));

                $this->_userVerification->create
                (
                    [
                        "user_id" => $id,
                        "code" => $data["code"],
                        "status" => true
                    ]
                );

                Mail::to($this->getParameter("login"))->send(new Verification($data));

                return true;
            }
            else
            {
                $this->_user->destroy($id);
                $this->addError("group", "The group 'User' doesn't exist.");

                return false;
            }
        }
        else
        {
            $this->setErrors($this->_user->getErrors());

            return false;
        }
        */
    }
}
