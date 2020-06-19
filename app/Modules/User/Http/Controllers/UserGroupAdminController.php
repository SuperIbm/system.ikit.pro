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

use Log;
use Auth;
use Util;

use App\Modules\User\Repositories\UserGroup;
use App\Modules\User\Repositories\UserGroupRole;
use App\Modules\User\Repositories\UserGroupPage;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\UserGroupAdminReadRequest;
use App\Modules\User\Http\Requests\UserGroupAdminDestroyRequest;

/**
 * Класс контроллер для работы с группами в административной системе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserGroupAdminController extends Controller
{
    /**
     * Репозитарий групп.
     *
     * @var \App\Modules\User\Repositories\UserGroup
     * @version 1.0
     * @since 1.0
     */
    private $_userGroup;

    /**
     * Репозитарий для выбранных разделов роли.
     *
     * @var \App\Modules\User\Repositories\UserGroupRole
     * @version 1.0
     * @since 1.0
     */
    private $_userGroupRole;

    /**
     * Репозитарий для выбранных страниц роли.
     *
     * @var \App\Modules\User\Repositories\UserGroupPage
     * @version 1.0
     * @since 1.0
     */
    private $_userGroupPage;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\UserGroup $userGroup Репозитарий группы.
     * @param \App\Modules\User\Repositories\UserGroupRole $userGroupRole Репозитарий для выбранных групп роли.
     * @param \App\Modules\User\Repositories\UserGroupPage $userGroupPage Репозитарий для выбранных страниц группы.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(UserGroup $userGroup, UserGroupRole $userGroupRole, UserGroupPage $userGroupPage)
    {
        $this->_userGroup = $userGroup;
        $this->_userGroupRole = $userGroupRole;
        $this->_userGroupPage = $userGroupPage;
    }

    /**
     * Получение группы.
     *
     * @param int $id ID группы.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function get($id)
    {
        $data = $this->_userGroup->get($id);

        if($data)
        {
            $pages = $this->_userGroupPage->read([
                [
                    'property' => 'user_group_id',
                    'value' => $data['id']
                ]
            ]);

            if($pages) $data['pages'] = $pages;

            $roles = $this->_userGroupRole->read([
                [
                    'property' => 'user_group_id',
                    'value' => $data['id']
                ]
            ]);

            if($roles) $data['roles'] = $roles;

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
     * @param \App\Modules\User\Http\Requests\UserGroupAdminReadRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function read(UserGroupAdminReadRequest $request)
    {
        $filter = $request->input('filter');

        if($filter)
        {
            $filters = [
                [
                    "property" => "id",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "property" => "name_group",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "property" => "description_group",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ]
            ];
        }
        else $filters = null;

        $data = $this->_userGroup->read($filters, null, json_decode($request->input('sort'), true), $request->input('start'), $request->input('limit'));

        if($this->_userGroup->hasError() == false)
        {
            $data = [
                'data' => $data == null ? [] : $data,
                'total' => $this->_userGroup->count($filters),
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
        $userGroupId = $this->_userGroup->create($data);

        if($userGroupId)
        {
            if($request->input('roles'))
            {
                $roles = $request->input('roles');

                for($i = 0; $i < count($roles); $i++)
                {
                    $sections = [
                        "user_group_id" => $userGroupId,
                        "user_role_id" => $roles[$i]
                    ];

                    $this->_userGroupRole->create($sections);
                }
            }

            if($request->input('pages'))
            {
                $pages = $request->input('pages');

                for($i = 0; $i < count($pages); $i++)
                {
                    $this->_userGroupPage->create([
                        'user_group_id' => $userGroupId,
                        'page_id' => $pages[$i]
                    ]);
                }
            }

            Log::info('Success: Create a group.', [
                'module' => "UserGroup",
                'login' => Auth::user()->login,
                'type' => 'create'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Create a group.', [
                'module' => "UserGroup",
                'login' => Auth::user()->login,
                'type' => 'create'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_userGroup->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }


    /**
     * Обновление данных.
     *
     * @param int $id ID группы.
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function update(int $id, Request $request)
    {
        $data = $request->all();
        $data["status"] = ($data["status"] == "on" || $id == 1 || $id == 2 || $id == 3) ? true : false;
        $status = $this->_userGroup->update($id, $data);

        if($status)
        {
            if($id != 1 && $id != 2 && $id != 3)
            {
                $userGroupRoles = $this->_userGroupRole->read([
                    [
                        'property' => 'user_group_id',
                        'value' => $id
                    ]
                ]);

                if($userGroupRoles)
                {
                    for($i = 0; $i < count($userGroupRoles); $i++)
                    {
                        $this->_userGroupRole->destroy($userGroupRoles[$i]['id']);
                    }
                }

                if($request->input('roles'))
                {
                    $roles = $request->input('roles');

                    for($i = 0; $i < count($roles); $i++)
                    {
                        $sections = [
                            "user_group_id" => $id,
                            "user_role_id" => $roles[$i]
                        ];

                        $this->_userGroupRole->create($sections);
                    }
                }
            }


            $userGroupPages = $this->_userGroupPage->read([
                [
                    'property' => 'user_group_id',
                    'value' => $id
                ]
            ]);

            if($userGroupPages)
            {
                for($i = 0; $i < count($userGroupPages); $i++)
                {
                    $this->_userGroupPage->destroy($userGroupPages[$i]['id']);
                }
            }

            if($request->input('pages'))
            {
                $pages = $request->input('pages');

                for($i = 0; $i < count($pages); $i++)
                {
                    $this->_userGroupPage->create([
                        'user_group_id' => $id,
                        'page_id' => $pages[$i]
                    ]);
                }
            }

            Log::info('Success: Update the group.', [
                'module' => "UserGroup",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Update the group.', [
                'module' => "UserGroup",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_userGroup->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }


    /**
     * Удаление данных.
     *
     * @param \App\Modules\User\Http\Requests\UserGroupAdminDestroyRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UserGroupAdminDestroyRequest $request)
    {
        $ids = json_decode($request->input('ids'), true);
        $idsAllowed = [];

        for($i = 0; $i < count($ids); $i++)
        {
            if($ids[$i] != 1 && $ids[$i] != 2 && $ids[$i] != 3) $idsAllowed[] = $ids[$i];
        }

        $status = $this->_userGroup->destroy($idsAllowed);

        if($status == true && $this->_userGroup->hasError() == false)
        {
            Log::info('Success: Destroy the group.', [
                'module' => "UserGroup",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Destroy the group.', [
                'module' => "UserGroup",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_userGroup->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
