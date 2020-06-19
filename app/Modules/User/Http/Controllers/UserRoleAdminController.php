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

use App\Modules\User\Repositories\UserRole;
use App\Modules\User\Repositories\UserRoleAdminSection;
use App\Modules\User\Repositories\UserRolePage;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use App\Modules\User\Http\Requests\UserRoleAdminReadRequest;
use App\Modules\User\Http\Requests\UserRoleAdminDestroyRequest;

/**
 * Класс контроллер для работы с ролями в административной системе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserRoleAdminController extends Controller
{
    /**
     * Репозитарий ролей.
     *
     * @var \App\Modules\User\Repositories\UserRole
     * @version 1.0
     * @since 1.0
     */
    private $_userRole;

    /**
     * Репозитарий для выбранных разделов роли.
     *
     * @var \App\Modules\User\Repositories\UserRoleAdminSection
     * @version 1.0
     * @since 1.0
     */
    private $_userRoleAdminSection;

    /**
     * Репозитарий для выбранных страниц роли.
     *
     * @var \App\Modules\User\Repositories\UserRolePage
     * @version 1.0
     * @since 1.0
     */
    private $_userRolePage;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\UserRole $userRole Репозитарий ролей.
     * @param \App\Modules\User\Repositories\UserRoleAdminSection $userRoleAdminSection Репозитарий для выбранных разделов роли.
     * @param \App\Modules\User\Repositories\UserRolePage $userRolePage Репозитарий для выбранных страниц роли.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(UserRole $userRole, UserRoleAdminSection $userRoleAdminSection, UserRolePage $userRolePage)
    {
        $this->_userRole = $userRole;
        $this->_userRoleAdminSection = $userRoleAdminSection;
        $this->_userRolePage = $userRolePage;
    }


    /**
     * Получение роли.
     *
     * @param int $id ID роли.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function get($id)
    {
        $data = $this->_userRole->get($id);

        if($data)
        {
            if($data)
            {
                $pages = $this->_userRolePage->read([
                    [
                        'property' => 'user_role_id',
                        'value' => $data['id']
                    ]
                ]);

                if($pages) $data['pages'] = $pages;

                $adminSection = $this->_userRoleAdminSection->read([
                    [
                        'property' => 'user_role_id',
                        'value' => $data['id']
                    ]
                ]);

                if($adminSection) $data['adminSections'] = $adminSection;
            }

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
     * @param \App\Modules\User\Http\Requests\UserRoleAdminReadRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function read(UserRoleAdminReadRequest $request)
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
                    "property" => "name_role",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ],
                [
                    "property" => "description_role",
                    "operator" => "like",
                    "value" => $filter,
                    "logic" => "or"
                ]
            ];
        }
        else $filters = null;

        $data = $this->_userRole->read($filters, null, json_decode($request->input('sort'), true), $request->input('start'), $request->input('limit'));

        if($this->_userRole->hasError() == false)
        {
            $data = [
                'data' => $data == null ? [] : $data,
                'total' => $this->_userRole->count($filters),
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
        $userRoleId = $this->_userRole->create($data);

        if($userRoleId)
        {
            if($request->input('sections'))
            {
                $sections = $request->input('sections');

                foreach($sections as $k => $v)
                {
                    $sections[$k]['user_role_id'] = $userRoleId;
                    $sections[$k]['admin_section_id'] = $k;

                    $this->_userRoleAdminSection->create($sections[$k]);
                }
            }

            if($request->input('pages'))
            {
                $pages = $request->input('pages');

                for($i = 0; $i < count($pages); $i++)
                {
                    $this->_userRolePage->create([
                        'user_role_id' => $userRoleId,
                        'page_id' => $pages[$i]
                    ]);
                }
            }

            Log::info('Success: Create a role.', [
                'module' => "UserRole",
                'login' => Auth::user()->login,
                'type' => 'create'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Create a role.', [
                'module' => "UserRole",
                'login' => Auth::user()->login,
                'type' => 'create'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_userRole->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }


    /**
     * Обновление данных.
     *
     * @param int $id ID роли.
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function update(int $id, Request $request)
    {
        $data = $request->all();

        $data["status"] = ($data["status"] == "on" || $id == 1 || $id == 2) ? true : false;

        $status = $this->_userRole->update($id, $data);

        if($status)
        {
            if($id != 1 && $id != 2)
            {
                $userRoleAdminSections = $this->_userRoleAdminSection->read([
                    [
                        'property' => 'user_role_id',
                        'value' => $id
                    ]
                ]);

                if($userRoleAdminSections)
                {
                    for($i = 0; $i < count($userRoleAdminSections); $i++)
                    {
                        $this->_userRoleAdminSection->destroy($userRoleAdminSections[$i]['id']);
                    }
                }

                if($request->input('sections'))
                {
                    $sections = $request->input('sections');

                    foreach($sections as $k => $v)
                    {
                        $sections[$k]['user_role_id'] = $id;
                        $sections[$k]['admin_section_id'] = $k;

                        $this->_userRoleAdminSection->create($sections[$k]);
                    }
                }

                $userRolePages = $this->_userRolePage->read([
                    [
                        'property' => 'user_role_id',
                        'value' => $id
                    ]
                ]);

                if($userRolePages)
                {
                    for($i = 0; $i < count($userRolePages); $i++)
                    {
                        $this->_userRolePage->destroy($userRolePages[$i]['id']);
                    }
                }

                if($request->input('pages'))
                {
                    $pages = $request->input('pages');

                    for($i = 0; $i < count($pages); $i++)
                    {
                        $this->_userRolePage->create([
                            'user_role_id' => $id,
                            'page_id' => $pages[$i]
                        ]);
                    }
                }
            }

            Log::info('Success: Update the role.', [
                'module' => "UserRole",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Update the role.', [
                'module' => "UserRole",
                'login' => Auth::user()->login,
                'type' => 'update'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_userRole->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }


    /**
     * Удаление данных.
     *
     * @param \App\Modules\User\Http\Requests\UserRoleAdminDestroyRequest $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(UserRoleAdminDestroyRequest $request)
    {
        $ids = json_decode($request->input('ids'), true);
        $idsAllowed = [];

        for($i = 0; $i < count($ids); $i++)
        {
            if($ids[$i] != 1 && $ids[$i] != 2) $idsAllowed[] = $ids[$i];
        }

        $status = $this->_userRole->destroy($idsAllowed);

        if($status == true && $this->_userRole->hasError() == false)
        {
            Log::info('Success: Destroy the role.', [
                'module' => "UserRole",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => true
            ];
        }
        else
        {
            Log::warning('Fail: Destroy the role.', [
                'module' => "UserRole",
                'login' => Auth::user()->login,
                'type' => 'destroy'
            ]);

            $data = [
                'success' => false,
                'message' => $this->_userRole->getErrorMessage()
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
