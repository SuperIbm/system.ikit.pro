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
use Auth;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Actions\UserGetAction;
use App\Modules\User\Actions\UserReadAction;
use App\Modules\User\Actions\UserCreateAction;
use App\Modules\User\Actions\UserUpdateAction;

use App\Modules\User\Http\Requests\UserAdminReadRequest;
use App\Modules\User\Http\Requests\UserAdminDestroyRequest;

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
     * @param \App\Modules\User\Http\Requests\UserAdminReadRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function read(UserAdminReadRequest $request)
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
            "school" => 1,
            "user" => [
                'login' => "test2@test.com",
                'password' => "123456",
                'first_name' => "Test",
                'second_name' => "User",
                'status' => true
            ],
            'roles' => [
                1
            ],
            'address' => [
                'postal_code' => "127550",
                'country' => "Россия",
                'city' => "Москва",
                'street_address' => "Дмитровское шоссе, 37к1",
            ]

            /*"school" => School::getId(),
            "user" => $request->input('user'),
            "image" => ($request->hasFile('image') && $request->file('image')->isValid()) ? $request->file('image') : null,
            'roles' => $request->input('roles'),
            'address' => $request->input('address')*/
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true
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
            "school" => 1,
            "user" => [
                'login' => "test2@test.com",
                'password' => "123456",
                'first_name' => "Test",
                'second_name' => "User",
                'status' => true
            ],
            'roles' => [
                1
            ],
            'address' => [
                'postal_code' => "127550",
                'country' => "Россия",
                'city' => "Москва",
                'street_address' => "Дмитровское шоссе, 37к1",
            ]

            /*"school" => School::getId(),
            "user" => $request->input('user'),
            "image" => ($request->hasFile('image') && $request->file('image')->isValid()) ? $request->file('image') : null,
            'roles' => $request->input('roles'),
            'address' => $request->input('address')*/
        ])->run();

        if(!$action->hasError())
        {
            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning(trans('access::http.controllers.userController.update.log'), [
                'module' => "User",
                'type' => 'create',
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

            echo $action->getErrorMessage();
            exit;

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
        $status = $this->_user->update($id, [
            "password" => $data["password"] = bcrypt($request->get("password"))
        ]);

        if($status)
        {
            Log::info('Success: Update the user password.', [
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
            Log::warning('Fail: Update the user password.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_user->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Удаление данных.
     *
     * @param \App\Modules\User\Http\Requests\UserAdminDestroyRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UserAdminDestroyRequest $request)
    {
        $ids = json_decode($request->input('ids'), true);
        $status = $this->_user->destroy($ids);

        if($status == true && $this->_user->hasError() == false)
        {
            Log::info('Success: Destroy the user.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Destroy the user.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_user->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
