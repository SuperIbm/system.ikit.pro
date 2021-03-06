<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\User\Http\Controllers;

use School;
use Log;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Actions\UserGetAction;
use App\Modules\User\Actions\UserReadAction;
use App\Modules\User\Actions\UserCreateAction;
use App\Modules\User\Actions\UserUpdateAction;
use App\Modules\User\Actions\UserPasswordAction;
use App\Modules\User\Actions\UserDestroyAction;

use App\Modules\User\Http\Requests\UserReadRequest;
use App\Modules\User\Http\Requests\UserDestroyRequest;

/**
 * Класс контроллер для работы с пользователями в административной системе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserController extends Controller
{
    /**
     * Получение пользователя.
     *
     * @param int $id ID пользователя.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function get($id)
    {
        $action = app(UserGetAction::class);

        $data = $action->setParameters([
            "id" => $id,
            "school" => School::getId()
        ])->run();

        if(!$action->hasError())
        {
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
            Log::warning(trans('access::http.controllers.userController.get.log'), [
                'module' => "User",
                'type' => 'get',
                'parameters' => [
                    "id" => $id
                ],
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => $action->getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Чтение данных.
     *
     * @param \App\Modules\User\Http\Requests\UserReadRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function read(UserReadRequest $request)
    {
        $action = app(UserReadAction::class);

        $data = $action->setParameters([
            "school" => School::getId(),
            "filter" => $request->input('filter'),
            'sort' => json_decode($request->input('sort'), true),
            'start' => $request->input('start'),
            'limit' => $request->input('limit')
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'data' => $data ? $data : []
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userController.read.log'), [
                'module' => "User",
                'type' => 'read',
                'request' => $request->all(),
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => $action->getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Добавление данных.
     *
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function create(Request $request)
    {
        $action = app(UserCreateAction::class);

        $action->setParameters([
            "school" => School::getId(),
            "user" => $request->input('user'),
            "image" => ($request->hasFile('image') && $request->file('image')
                    ->isValid()) ? $request->file('image') : null,
            'roles' => $request->input('roles'),
            'address' => $request->input('address')
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'message' => trans('access::http.controllers.userController.create.message')
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userController.create.log'), [
                'module' => "User",
                'type' => 'create',
                'request' => $request->all(),
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => $action->getErrorMessage()
            ]);

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
     * @param int $id ID пользователя.
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function update(int $id, Request $request)
    {
        $action = app(UserUpdateAction::class);

        $action->setParameters([
            "id" => $id,
            "school" => School::getId(),
            "user" => $request->input('user'),
            "image" => ($request->hasFile('image') && $request->file('image')
                    ->isValid()) ? $request->file('image') : null,
            'roles' => $request->input('roles'),
            'address' => $request->input('address')
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'message' => trans('access::http.controllers.userController.update.message')
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userController.update.log'), [
                'module' => "User",
                'type' => 'update',
                'request' => $request->all(),
                'parameters' => [
                    'id' => $id
                ],
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => $action->getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Обновление пароля пользователя.
     *
     * @param int $id ID пользователя.
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function password(int $id, Request $request)
    {
        $action = app(UserPasswordAction::class);

        $action->setParameters([
            "id" => $id,
            "password" => $request->get("password")
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'message' => trans('access::http.controllers.userController.password.message')
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userController.password.log'), [
                'module' => "User",
                'type' => 'update',
                'parameters' => [
                    'id' => $id
                ],
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => $action->getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Удаление данных.
     *
     * @param \App\Modules\User\Http\Requests\UserDestroyRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UserDestroyRequest $request)
    {
        $ids = json_decode($request->input('ids'), true);

        $action = app(UserDestroyAction::class);

        $action->setParameters([
            "ids" => $ids
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true,
                'message' => trans('access::http.controllers.userController.destroy.message')
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userController.destroy.log'), [
                'module' => "User",
                'type' => 'destroy',
                'parameters' => [
                    'ids' => $ids
                ],
                'school' => [
                    'id' => School::getId(),
                    'index' => School::getIndex()
                ],
                'error' => $action->getErrorMessage()
            ]);

            $data = [
                'success' => false,
                'message' => $action->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
