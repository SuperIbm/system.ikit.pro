<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Http\Controllers;

use Log;
use Auth;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Modules\Access\Actions\AccessSiteSocialAction;
use App\Modules\Access\Actions\AccessSiteSignUpAction;
use App\Modules\Access\Actions\AccessVerifiedAction;
use App\Modules\Access\Actions\AccessSiteSendEmailVerificationAction;
use App\Modules\Access\Actions\AccessSiteForgetAction;
use App\Modules\Access\Actions\AccessSiteCheckResetPasswordAction;
use App\Modules\Access\Actions\AccessSiteResetAction;
use App\Modules\Access\Actions\AccessSiteUpdateAction;
use App\Modules\Access\Actions\AccessSitePasswordAction;

use App\Modules\Access\Http\Requests\AccessSiteSocialRequest;
use App\Modules\Access\Http\Requests\AccessSiteSignUpRequest;
use App\Modules\Access\Http\Requests\AccessSiteVerifiedRequest;
use App\Modules\Access\Http\Requests\AccessSiteForgetRequest;
use App\Modules\Access\Http\Requests\AccessSiteResetCheckRequest;
use App\Modules\Access\Http\Requests\AccessSiteResetRequest;
use App\Modules\Access\Http\Requests\AccessSitePasswordRequest;

/**
 * Класс контроллер для авторизации, аунтификации, регистрации и восстановление пароля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSiteController extends Controller
{
    /**
     * Регистрация или вход через социальную сеть.
     *
     * @param \App\Modules\Access\Http\Requests\AccessSiteSocialRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function social(AccessSiteSocialRequest $request)
    {
        $action = app(AccessSiteSocialAction::class);

        $data = $action->setParameters([
            "id" => $request->get("id"),
            "type" => $request->get("type"),
            "login" => $request->get("login"),
            "parameters" => $request->get("parameters"),
            "verified" => true
        ])->run();

        if($data)
        {
            Log::info('Success: Log in with social network.', [
                'module' => "Access",
                'type' => 'create'
            ]);

            $data = [
                'success' => true,
                'data' => $data
            ];
        }
        else
        {
            Log::warning('Fail: Log in with social network.', [
                'module' => "Access",
                'type' => 'create'
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Регистрация пользователя.
     *
     * @param \App\Modules\Access\Http\Requests\AccessSiteSignUpRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function signUp(AccessSiteSignUpRequest $request)
    {
        $accessSiteSignUpAction = app(AccessSiteSignUpAction::class);

        $data = $accessSiteSignUpAction->setParameters([
            "login" => $request->get("login"),
            "password" => $request->get("password"),
            "first_name" => $request->get("first_name"),
            "second_name" => $request->get("second_name"),
            "company" => $request->get("company"),
            "telephone" => $request->get("telephone"),
            "verified" => true
        ])->run();

        if($data)
        {
            Log::info('Success: A new user signed up.', [
                'module' => "Access",
                'type' => 'create'
            ]);

            $data = [
                'success' => true,
                'data' => $data
            ];
        }
        else
        {
            Log::warning('Fail: A new user did not signed up.', [
                'module' => "Access",
                'type' => 'create'
            ]);

            $data = [
                'success' => false,
                'message' => $accessSiteSignUpAction->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Верификация пользователя.
     *
     * @param int $id ID пользователя.
     * @param \App\Modules\Access\Http\Requests\AccessSiteVerifiedRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function verified(int $id, AccessSiteVerifiedRequest $request)
    {
        $accessSiteVerifiedAction = app(AccessVerifiedAction::class);

        $data = $accessSiteVerifiedAction->setParameters([
            "id" => $id,
            "code" => $request->get("code")
        ])->run();

        if($data)
        {
            Log::info('Success: The user was verified.', [
                'module' => "Access",
                'type' => 'update'
            ]);

            $data = [
                'success' => true,
                'data' => $data
            ];
        }
        else
        {
            Log::warning('Fail: The user was not verified.', [
                'module' => "Access",
                'type' => 'update'
            ]);

            $data = [
                'success' => false,
                'message' => $accessSiteVerifiedAction->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Отправка e-mail сообщения на верификацию.
     *
     * @param string $email Email для подтверждения.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function verify($email = null)
    {
        if($email)
        {
            $checked = true;
        }
        else
        {
            $checked = Auth::check();
            $email = Auth::user()->login;
        }

        if($checked)
        {
            $accessSiteSendEmailVerificationAction = app(AccessSiteSendEmailVerificationAction::class);

            $result = $accessSiteSendEmailVerificationAction->setParameters([
                "email" => $email
            ])->run();

            if($result)
            {
                Log::info('Success: The email for the user verification was sent.', [
                    'module' => "Access",
                    'type' => 'update'
                ]);

                $data = [
                    'success' => true
                ];
            }
            else
            {
                Log::warning('Fail: The email for the user verification was not sent.', [
                    'module' => "Access",
                    'type' => 'update'
                ]);

                $data = [
                    'success' => false,
                    'message' => $accessSiteSendEmailVerificationAction->getErrorMessage()
                ];
            }
        }
        else
        {
            $data = [
                'success' => false
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Отправка e-mail для восстановления пароля.
     *
     * @param \App\Modules\Access\Http\Requests\AccessSiteForgetRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function forget(AccessSiteForgetRequest $request)
    {
        $accessSiteForgetAction = app(AccessSiteForgetAction::class);

        $data = $accessSiteForgetAction->setParameters([
            "login" => $request->get("login")
        ])->run();

        if($data)
        {
            Log::info('Success: The email for recovery the password was sent.', [
                'module' => "Access",
                'type' => 'update'
            ]);

            $data = [
                'success' => true,
                'data' => $data
            ];
        }
        else
        {
            Log::warning('Fail: The email for recovery the password was not sent.', [
                'module' => "Access",
                'type' => 'update'
            ]);

            $data = [
                'success' => false,
                'message' => $accessSiteForgetAction->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Проверка возможности сбить пароль.
     *
     * @param int $id ID пользователя.
     * @param \App\Modules\Access\Http\Requests\AccessSiteResetCheckRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function resetCheck(int $id, AccessSiteResetCheckRequest $request)
    {
        $accessSiteCheckResetPasswordAction = app(AccessSiteCheckResetPasswordAction::class);

        $status = $accessSiteCheckResetPasswordAction->setParameters
        (
            [
                "id" => $id,
                "code" => $request->get("code")
            ]
        )->run();

        if($status)
        {
            $data = [
                'success' => true
            ];
        }
        else
        {
            $data = [
                'success' => false,
                'message' => $accessSiteCheckResetPasswordAction->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Установка нового пароля.
     *
     * @param int $id ID пользователя.
     * @param \App\Modules\Access\Http\Requests\AccessSiteResetRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function reset(int $id, AccessSiteResetRequest $request)
    {
        $accessSiteResetAction= app(AccessSiteResetAction::class);

        $status = $accessSiteResetAction->setParameters
        (
            [
                "id" => $id,
                "code" => $request->get("code"),
                "password" => $request->get("password"),
            ]
        )->run();

        if($status)
        {
            $data = [
                'success' => true
            ];
        }
        else
        {
            $data = [
                'success' => false,
                'message' => $accessSiteResetAction->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Обновление данных.
     *
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function update(Request $request)
    {
        $accessSiteUpdateAction= app(AccessSiteUpdateAction::class);

        $status = $accessSiteUpdateAction->setParameters
        (
            [
                "user" => Auth::user()->toArray(),
                "data" => [
                    "first_name" => $request->get("first_name"),
                    "second_name" => $request->get("second_name"),
                    "email" => $request->get("email"),
                    "telephone" => $request->get("telephone"),
                    "postal_code" => $request->get("postal_code"),
                    "country" => $request->get("country"),
                    "city" => $request->get("city"),
                    "region" => $request->get("region"),
                    "street_address" => $request->get("street_address"),
                    "company_name" => $request->get("company_name")
                ]
            ]
        )->run();

        if($status)
        {
            Log::info('Success: Update the user.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Update the user.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => false,
                'message' => $accessSiteUpdateAction->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Изменение пароля.
     *
     * @param \App\Modules\Access\Http\Requests\AccessSitePasswordRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function password(AccessSitePasswordRequest $request)
    {
        $accessSiteResetAction= app(AccessSitePasswordAction::class);

        $status = $accessSiteResetAction->setParameters
        (
            [
                "user" => Auth::user()->toArray(),
                "password_current" => $request->get("password_current"),
                "password" => $request->get("password"),
            ]
        )->run();

        if($status)
        {
            $data = [
                'success' => true
            ];
        }
        else
        {
            $data = [
                'success' => false,
                'message' => $accessSiteResetAction->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
