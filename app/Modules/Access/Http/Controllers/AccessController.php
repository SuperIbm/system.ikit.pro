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

use Auth;
use Log;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;

use App\Modules\Access\Actions\AccessCheckResetPasswordAction;
use App\Modules\Access\Actions\AccessForgetAction;
use App\Modules\Access\Actions\AccessResetAction;
use App\Modules\Access\Actions\AccessSendEmailVerificationAction;
use App\Modules\Access\Actions\AccessSignInAction;
use App\Modules\Access\Actions\AccessSignUpAction;
use App\Modules\Access\Actions\AccessSocialAction;
use App\Modules\Access\Actions\AccessUpdateAction;
use App\Modules\Access\Actions\AccessVerifiedAction;
use App\Modules\Access\Actions\AccessGateAction;
use App\Modules\Access\Actions\AccessPasswordAction;

use App\Modules\Access\Http\Requests\AccessForgetRequest;
use App\Modules\Access\Http\Requests\AccessPasswordRequest;
use App\Modules\Access\Http\Requests\AccessResetCheckRequest;
use App\Modules\Access\Http\Requests\AccessResetRequest;
use App\Modules\Access\Http\Requests\AccessSignInRequest;
use App\Modules\Access\Http\Requests\AccessSignUpRequest;
use App\Modules\Access\Http\Requests\AccessSocialRequest;
use App\Modules\Access\Http\Requests\AccessVerifiedRequest;

/**
 * Класс контроллер для авторизации и аунтификации.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessController extends Controller
{
    /**
     * Авторизация.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function gate()
    {
        if(Auth::check())
        {
            $data = app(AccessGateAction::class)->setParameters([
                "id" => Auth::user()->login
            ])->run();

            if($data)
            {
                $data = [
                    'success' => true,
                    'data' => $data
                ];
            }
            else
            {
                $data = [
                    'success' => false
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
     * Выход пользователя.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function logout()
    {
        Auth::logout();
        return response()->json(['success' => true]);
    }

    /**
     * Регистрация или вход через социальную сеть.
     *
     * @param \App\Modules\Access\Http\Requests\AccessSocialRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function social(AccessSocialRequest $request)
    {
        $action = app(AccessSocialAction::class);

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
     * Авторизация пользователя.
     *
     * @param \App\Modules\Access\Http\Requests\AccessSignInRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function signIn(/*AccessSignInRequest $request*/)
    {
        $action = app(AccessSignInAction::class);

        $data = $action->setParameters([
            //"login" => $request->get("login"),
            //"password" => $request->get("password"),
            //"remember" => $request->get("remember")

            "login" => "test@test.com",
            "password" => "admin",
            "remember" => true
        ])->run();

        if($data)
        {
            Log::info('Success: User signed in.', [
                'module' => "Access",
                'type' => 'Sign in'
            ]);

            $data = [
                'success' => true,
                'data' => $data
            ];
        }
        else
        {
            Log::warning('Fail: User signed in.', [
                'module' => "Access",
                'type' => 'Sign in'
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
     * @param \App\Modules\Access\Http\Requests\AccessSignUpRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function signUp(AccessSignUpRequest $request)
    {
        $action = app(AccessSignUpAction::class);

        $data = $action->setParameters([
            "login" => $request->get("login"),
            "password" => $request->get("password"),
            "first_name" => $request->get("first_name"),
            "second_name" => $request->get("second_name"),
            "company" => $request->get("company"),
            "telephone" => $request->get("telephone"),
            "uid" => $request->get("uid"),
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
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Верификация пользователя.
     *
     * @param int $id ID пользователя.
     * @param \App\Modules\Access\Http\Requests\AccessVerifiedRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function verified(int $id, AccessVerifiedRequest $request)
    {
        $accessVerifiedAction = app(AccessVerifiedAction::class);

        $data = $accessVerifiedAction->setParameters([
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
                'message' => $accessVerifiedAction->getErrorMessage()
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
            $action = app(AccessSendEmailVerificationAction::class);

            $result = $action->setParameters([
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
                    'message' => $action->getErrorMessage()
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
     * @param \App\Modules\Access\Http\Requests\AccessForgetRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function forget(AccessForgetRequest $request)
    {
        $action = app(AccessForgetAction::class);

        $data = $action->setParameters([
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
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Проверка возможности сбить пароль.
     *
     * @param int $id ID пользователя.
     * @param \App\Modules\Access\Http\Requests\AccessResetCheckRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function resetCheck(int $id, AccessResetCheckRequest $request)
    {
        $action = app(AccessCheckResetPasswordAction::class);

        $status = $action->setParameters([
            "id" => $id,
            "code" => $request->get("code")
        ])->run();

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
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Установка нового пароля.
     *
     * @param int $id ID пользователя.
     * @param \App\Modules\Access\Http\Requests\AccessResetRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function reset(int $id, AccessResetRequest $request)
    {
        $action = app(AccessResetAction::class);

        $status = $action->setParameters([
            "id" => $id,
            "code" => $request->get("code"),
            "password" => $request->get("password"),
        ])->run();

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
                'message' => $action->getErrorMessage()
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
        $action = app(AccessUpdateAction::class);

        $status = $action->setParameters([
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
        ])->run();

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
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Изменение пароля.
     *
     * @param \App\Modules\Access\Http\Requests\AccessPasswordRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function password(AccessPasswordRequest $request)
    {
        $accessResetAction = app(AccessPasswordAction::class);

        $status = $accessResetAction->setParameters([
            "user" => Auth::user()->toArray(),
            "password_current" => $request->get("password_current"),
            "password" => $request->get("password"),
        ])->run();

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
                'message' => $accessResetAction->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
