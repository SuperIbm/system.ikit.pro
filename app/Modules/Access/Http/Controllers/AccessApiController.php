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

use Illuminate\Routing\Controller;
use App\Modules\Access\Http\Requests\AccessApiTokenRequest;
use App\Modules\Access\Http\Requests\AccessApiRefreshRequest;
use App\Modules\Access\Actions\AccessApiTokenAction;
use App\Modules\Access\Actions\AccessApiRefreshAction;
use App\Modules\Access\Http\Requests\AccessApiClientRequest;
use App\Modules\Access\Actions\AccessApiClientAction;
use Illuminate\Http\JsonResponse;

/**
 * Класс контроллер для генерации ключей доступа к API.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessApiController extends Controller
{
    /**
     * Генерация клиента.
     *
     * @param \App\Modules\Access\Http\Requests\AccessApiClientRequest $request Запрос на генерацию API клиента.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function client(AccessApiClientRequest $request): JsonResponse
    {
        $accessApiClientAction = app(AccessApiClientAction::class);

        $data = $accessApiClientAction->setParameters([
            "login" => $request->get('login'),
            "password" => $request->get('password')
        ])->run();

        if($data)
        {
            return response()->json([
                'success' => true,
                "data" => $data
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => $accessApiClientAction->getErrorMessage()
            ])->setStatusCode(400);
        }
    }

    /**
     * Генерация клиента.
     *
     * @param \App\Modules\Access\Http\Requests\AccessApiTokenRequest $request Запрос на генерацию токена.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function token(AccessApiTokenRequest $request): JsonResponse
    {
        $accessApiTokenAction = app(AccessApiTokenAction::class);

        $data = $accessApiTokenAction->setParameters([
            "secret" => $request->get('secret')
        ])->run();

        if($data)
        {
            return response()->json([
                'success' => true,
                "data" => $data
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => $accessApiTokenAction->getErrorMessage()
            ])->setStatusCode(400);
        }
    }

    /**
     * Генерация клиента.
     *
     * @param \App\Modules\Access\Http\Requests\AccessApiRefreshRequest $request Запрос на обновление токена.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function refresh(AccessApiRefreshRequest $request): JsonResponse
    {
        $accessApiRefreshAction = app(AccessApiRefreshAction::class);

        $data = $accessApiRefreshAction->setParameters([
            "refreshToken" => $request->get('refreshToken'),
        ])->run();

        if($data)
        {
            return response()->json([
                'success' => true,
                "data" => $data
            ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => $accessApiRefreshAction->getErrorMessage()
            ])->setStatusCode(400);
        }
    }
}
