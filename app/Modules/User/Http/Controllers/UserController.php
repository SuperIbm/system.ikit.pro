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
use Hash;
use Log;
use Auth;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Actions\UserGetAction;
use App\Modules\User\Actions\UserReadAction;
use App\Modules\User\Actions\UserCreateAction;

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
            "school" => School::getId(),
            "user" => $request->input('user'),
            "image" => ($request->hasFile('image') && $request->file('image')->isValid()) ? $request->file('image') : null,
            'roles' => $request->input('roles'),
            'address' => $request->input('address')
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
        $data = $request->all();
        $data["status"] = ($data["status"] == "on" || $id == 1) ? true : false;

        if($request->hasFile('image') && $request->file('image')->isValid())
        {
            $data['image_small_id'] = $request->file('image');
            $data['image_middle_id'] = $request->file('image');
        }

        $status = $this->_user->update($id, $data);

        if($status)
        {
            if($id != 1)
            {
                if(!$request->get("no_set_groups", false))
                {
                    $userGroupUsers = $this->_userGroupUser->read([
                        [
                            'property' => 'user_id',
                            'value' => $id
                        ]
                    ]);

                    if($userGroupUsers)
                    {
                        for($i = 0; $i < count($userGroupUsers); $i++)
                        {
                            $this->_userGroupUser->destroy($userGroupUsers[$i]['id']);
                        }
                    }

                    if($request->input('groups'))
                    {
                        $groups = $request->input('groups');

                        for($i = 0; $i < count($groups); $i++)
                        {
                            $this->_userGroupUser->create([
                                'user_id' => $id,
                                'user_group_id' => $groups[$i]
                            ]);
                        }
                    }
                }

                if(!$request->get("no_set_verification", false))
                {
                    $userVerifications = $this->_userVerification->read([
                        [
                            'property' => 'user_id',
                            'value' => $id
                        ]
                    ]);

                    if($userVerifications)
                    {
                        $userVerification = $userVerifications[0];

                        $this->_userVerification->update($userVerification["id"], [
                            'status' => $data["verified"]
                        ]);
                    }
                    else
                    {
                        $this->_userVerification->create([
                            'user_id' => $id,
                            'code' => $id . Hash::make(intval(Carbon::now()->format("U")) + rand(1000000, 100000000)),
                            'status' => $data["verified"]
                        ]);
                    }
                }
            }

            //

            $filters = [
                [
                    "table" => "user_companies",
                    "property" => "user_id",
                    "operator" => "=",
                    "value" => $id,
                    "logic" => "and"
                ]
            ];

            $companies = $this->_userCompany->read($filters);

            if($companies)
            {
                $company = $companies[0];
                $company["company_name"] = $data["company_name"];

                $this->_userCompany->update($company["id"], $company);
            }
            else
            {
                $this->_userCompany->create([
                    'user_id' => $id,
                    'company_name' => $data["company_name"]
                ]);
            }

            //

            $filters = [
                [
                    "table" => "user_addresses",
                    "property" => "user_id",
                    "operator" => "=",
                    "value" => $id,
                    "logic" => "and"
                ]
            ];

            $address = [
                'user_id' => $id,
                'postal_code' => $request->get("postal_code"),
                'country' => $request->get("country"),
                'region' => $request->get("region"),
                'city' => $request->get("city"),
                'street_address' => $request->get("street_address"),
                'latitude' => $request->get("latitude"),
                'longitude' => $request->get("longitude"),
            ];

            $records = $this->_userAddress->read($filters);

            if($records) $this->_userAddress->update($records[0]["id"], $address);
            else $this->_userAddress->create($address);

            //

            Log::info('Success: Update the user.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $user = $this->_user->get($id);

            $data = [
                'success' => true,
                'data' => [
                    'image' => $user["image_small_id"] ? true : false
                ]
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
                'message' => $this->_user->getErrorMessage()
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
