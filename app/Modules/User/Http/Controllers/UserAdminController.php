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

use Hash;
use Log;
use Auth;
use Carbon\Carbon;

use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserGroup;
use App\Modules\User\Repositories\UserGroupUser;
use App\Modules\User\Repositories\UserVerification;
use App\Modules\User\Repositories\UserCompany;
use App\Modules\User\Repositories\UserAddress;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

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
class UserAdminController extends Controller
{
    /**
     * Репозитарий для выбранных групп пользователя.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private $_user;

    /**
     * Репозитарий для групп пользователя.
     *
     * @var \App\Modules\User\Repositories\UserCompany
     * @version 1.0
     * @since 1.0
     */
    private $_userCompany;

    /**
     * Репозитарий для адресов пользователей.
     *
     * @var \App\Modules\User\Repositories\UserAddress
     * @version 1.0
     * @since 1.0
     */
    private $_userAddress;

    /**
     * Репозитарий для групп пользователя.
     *
     * @var \App\Modules\User\Repositories\UserGroup
     * @version 1.0
     * @since 1.0
     */
    private $_userGroup;

    /**
     * Репозитарий для выбранных групп пользователя.
     *
     * @var \App\Modules\User\Repositories\UserGroupUser
     * @version 1.0
     * @since 1.0
     */
    private $_userGroupUser;

    /**
     * Репозитарий для верификации пользователя.
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
     * @param \App\Modules\User\Repositories\UserCompany $userCompany Репозитарий компаний.
     * @param \App\Modules\User\Repositories\UserAddress $userAddress Репозитарий адресов.
     * @param \App\Modules\User\Repositories\UserGroup $userGroup Репозитарий групп пользователя.
     * @param \App\Modules\User\Repositories\UserGroupUser $userGroupUser Репозитарий для выбранных групп пользователя.
     * @param \App\Modules\User\Repositories\UserVerification $userVerification Репозитарий для верификации пользователя..
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserCompany $userCompany, UserAddress $userAddress, UserGroup $userGroup, UserGroupUser $userGroupUser, UserVerification $userVerification)
    {
        $this->_user = $user;
        $this->_userCompany = $userCompany;
        $this->_userAddress = $userAddress;
        $this->_userGroup = $userGroup;
        $this->_userGroupUser = $userGroupUser;
        $this->_userVerification = $userVerification;
    }

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
        $filters = [
            [
                "table" => "users",
                "property" => "id",
                "operator" => "=",
                "value" => $id,
            ],
        ];

        $data = $this->_user->read($filters, null, null, null, null, [
            "userCompany",
            "userGroupUsers",
            "verification",
            "userAddress"
        ]);

        if($data)
        {
            $data = $data[0];

            if($data["user_address"])
            {
                unset($data["user_address"]["id"]);
                $data = array_merge($data, $data["user_address"]);
                unset($data["user_address"]);
            }

            $data["company_name"] = $data["user_company"] ? $data["user_company"]["company_name"] : null;
            $data["groups"] = [];

            if($data["user_group_users"])
            {
                for($z = 0; $z < count($data["user_group_users"]); $z++)
                {
                    $data["groups"][] = $this->_userGroup->get($data["user_group_users"][$z]["user_group_id"]);
                }

                unset($data["user_group_users"]);
            }

            if($data["verification"]) $data["verified"] = $data["verification"]["status"];
            else $data["verified"] = false;

            $data = [
                'data' => $data,
                'success' => true,
            ];
        }
        else
        {
            $data = [
                'success' => false,
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
        $filter = $request->input('filter');

        if($filter)
        {
            $filters = [
                [
                    "table" => "users",
                    "property" => "login",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "table" => "users",
                    "property" => "first_name",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "table" => "users",
                    "property" => "second_name",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "table" => "users",
                    "property" => "email",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "table" => "users",
                    "property" => "telephone",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ]
            ];
        }
        else $filters = null;

        $data = $this->_user->read($filters, null, json_decode($request->input('sort'), true), $request->input('start'), $request->input('limit'), [
            "userGroupUsers",
            "verification"
        ]);

        if($this->_user->hasError() == false)
        {
            if($data)
            {
                for($i = 0; $i < count($data); $i++)
                {
                    $data[$i]["verified"] = $data[$i]["verification"]["status"];

                    $data[$i]["groups"] = [];

                    if($data[$i]["user_group_users"])
                    {
                        for($z = 0; $z < count($data[$i]["user_group_users"]); $z++)
                        {
                            $data[$i]["groups"][] = $this->_userGroup->get($data[$i]["user_group_users"][$z]["user_group_id"]);
                        }

                        unset($data[$i]["user_group_users"]);
                    }
                }
            }

            $data = [
                'data' => $data == null ? [] : $data,
                'total' => $this->_user->count($filters),
                'success' => true
            ];
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
        $data = $request->all();
        $data["status"] = $data["status"] == "on" ? true : false;
        $data["password"] = bcrypt($data["password"]);

        if($request->hasFile('image') && $request->file('image')->isValid())
        {
            $data['image_small_id'] = $request->file('image');
            $data['image_middle_id'] = $request->file('image');
        }

        $userId = $this->_user->create($data);

        if($userId)
        {
            if($request->input('groups'))
            {
                $groups = $request->input('groups');

                for($i = 0; $i < count($groups); $i++)
                {
                    $this->_userGroupUser->create([
                        'user_id' => $userId,
                        'user_group_id' => $groups[$i]
                    ]);
                }
            }

            //

            $filters = [
                [
                    "table" => "user_companies",
                    "property" => "user_id",
                    "operator" => "=",
                    "value" => $userId,
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
                $this->_userCompany->create
                (
                    [
                        'user_id' => $userId,
                        'company_name' => $data["company_name"]
                    ]
                );
            }

            //

            $filters = [
                [
                    "table" => "user_addresses",
                    "property" => "user_id",
                    "operator" => "=",
                    "value" => $userId,
                    "logic" => "and"
                ]
            ];

            $address = [
                'user_id' => $userId,
                'postal_code' => $request->get("postal_code"),
                'country' => $request->get("country"),
                'region' => $request->get("region"),
                'city' => $request->get("city"),
                'street_address' => $request->get("street_address"),
                'latitude' => $request->get("latitude"),
                'longitude' => $request->get("longitude"),
            ];

            $records = $this->_userAddress->read($filters);

            if($records) $this->_userAddress->update($address["id"], $address);
            else $this->_userAddress->create($address);

            //

            $this->_userVerification->create([
                'user_id' => $userId,
                'code' => $userId.Hash::make(intval(Carbon::now()->format("U")) + rand(1000000, 100000000)),
                'status' => $data["verified"]
            ]);

            Log::info('Success: Create a user.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'create'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Create a user.', [
                'module' => "User",
                'login' => Auth::user()->login,
                'type' => 'create'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_user->getErrorMessage()
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
                            'code' => $id.Hash::make(intval(Carbon::now()->format("U")) + rand(1000000, 100000000)),
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
                $this->_userCompany->create
                (
                    [
                        'user_id' => $id,
                        'company_name' => $data["company_name"]
                    ]
                );
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
