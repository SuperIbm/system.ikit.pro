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
use Carbon\Carbon;
use App\Models\Action;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserGroupUser;
use App\Modules\User\Repositories\UserGroup;
use App\Modules\User\Repositories\UserVerification;
use App\Modules\Access\Tasks\AccessSiteSendEmailVerificationTask;
use App\Modules\User\Repositories\UserCompany;
use Illuminate\Support\Str;
use Kreait\Firebase\Auth;

/**
 * Регистрация нового пользователя через соцаильные сети.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSocialAction extends Action
{
    /**
     * Класс для работы с Firebase.
     *
     * @var \Kreait\Firebase\Auth
     * @version 1.0
     * @since 1.0
     */
    private $_auth;

    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private $_user;

    /**
     * Репозитарий компаний пользователей.
     *
     * @var \App\Modules\User\Repositories\UserCompany
     * @version 1.0
     * @since 1.0
     */
    private $_userCompany;

    /**
     * Репозитарий групп пользователя.
     *
     * @var \App\Modules\User\Repositories\UserGroupUser
     * @version 1.0
     * @since 1.0
     */
    private $_userGroupUser;

    /**
     * Репозитарий групп.
     *
     * @var \App\Modules\User\Repositories\UserGroup
     * @version 1.0
     * @since 1.0
     */
    private $_userGroup;

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
     * @param \Kreait\Firebase\Auth $auth Класс для работы с Firebase.
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserCompany $userCompany Репозитарий компаний пользователей.
     * @param \App\Modules\User\Repositories\UserGroupUser $userGroupUser Репозитарий групп пользователя.
     * @param \App\Modules\User\Repositories\UserGroup $userGroup Репозитарий групп.
     * @param \App\Modules\User\Repositories\UserVerification $userVerification Репозитарий верификации пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Auth $auth, User $user, UserCompany $userCompany, UserGroupUser $userGroupUser, UserGroup $userGroup, UserVerification $userVerification)
    {
        $this->_auth = $auth;
        $this->_user = $user;
        $this->_userCompany = $userCompany;
        $this->_userGroupUser = $userGroupUser;
        $this->_userGroup = $userGroup;
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
        if($this->_check($this->getParameter("id"), $this->getParameter("type")))
        {
            $accessApiClientAction = app(AccessApiClientAction::class);

            $client = $accessApiClientAction->setParameters([
                "login" => $this->getParameter("login"),
                "force" => true
            ])->run();

            if($client)
            {
                $accessApiTokenAction = app(AccessApiTokenAction::class);

                $token = $accessApiTokenAction->setParameters([
                    "secret" => $client["secret"]
                ])->run();

                $gate = app(AccessGateAction::class)->setParameters([
                    "id" => $client["user"]["id"]
                ])->run();

                return [
                    "gate" => $gate,
                    "client" => $client,
                    "token" => $token
                ];
            }
            else
            {
                $parameters = $this->getParameter("parameters");

                $data = [
                    "login" => $this->getParameter("login"),
                    "password" => bcrypt(Str::random(8)),
                    "status" => true,
                    "first_name" => $parameters["first_name"],
                    "second_name" => $parameters["second_name"]
                ];

                $id = $this->_user->create($data);

                if($id)
                {
                    $this->_userCompany->create([
                        'user_id' => $id
                    ]);

                    $data["id"] = $id;

                    $groups = $this->_userGroup->read([
                        [
                            'property' => "name_group",
                            'value' => "User"
                        ]
                    ]);

                    if($groups)
                    {
                        $this->_userGroupUser->create([
                            "user_group_id" => $groups[0]["id"],
                            "user_id" => $id
                        ]);

                        $data["code"] = $id . Hash::make(intval(Carbon::now()->format("U")) + rand(1000000, 100000000));

                        $this->_userVerification->create([
                            "user_id" => $id,
                            "code" => $data["code"],
                            "status" => $this->getParameter("verified", false)
                        ]);

                        if(!$this->_userVerification->hasError())
                        {
                            if(!$this->getParameter("verified", false))
                            {
                                $accessSiteSendEmailVerificationTask = app(AccessSiteSendEmailVerificationTask::class);

                                $result = $accessSiteSendEmailVerificationTask->setParameters([
                                    "id" => $id
                                ])->run();
                            }
                            else $result = true;

                            if($result)
                            {
                                $gate = app(AccessGateAction::class)->setParameters([
                                    "id" => $id
                                ])->run();

                                $accessApiClientAction = app(AccessApiClientAction::class);

                                $client = $accessApiClientAction->setParameters([
                                    "login" => $data["login"],
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
                                $this->setErrors($accessSiteSendEmailVerificationTask->getErrors());

                                return false;
                            }
                        }
                        else
                        {
                            $this->_user->destroy($id);
                            $this->setErrors($this->_userVerification->getErrors());

                            return false;
                        }
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
            }
        }
        else return false;
    }

    /**
     * Проверка возможности подобной авторизации.
     *
     * @param string $id Индификаионный номер авторизации.
     * @param string $type Название социальной сети.
     *
     * @return mixed Вернет успешность проверки.
     * @since 1.0
     * @version 1.0
     */
    private function _check($id, string $type): bool
    {
        try
        {
            $this->_auth->verifyIdToken($id);

            return true;
        }
        catch(\Exception $err)
        {
            $this->addError("access", $err->getMessage());

            return false;
        }
    }
}
