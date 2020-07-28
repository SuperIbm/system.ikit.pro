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

use Cache;
use Util;
use App\Models\Action;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserRole;

/**
 * Получение всех доступов к разделам.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessGateAction extends Action
{
    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private $_user;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user)
    {
        $this->_user = $user;
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
        $id = $this->getParameter("id");
        $key = Util::getKey("Access", "Gate", "User", "UserItem", $id);

        \Cache::flush();

        $user = Cache::tags(["User", "UserItem"])->remember($key, 60 * 24 * 30,
            function() use ($id)
            {
                $data = [
                    'user' => [],
                    'schools' => []
                ];

                $user = $this->_user->get($id, true, null,
                    [
                        "verification",
                        "schools.school",
                        "schools.roles.role.userRole",
                        "schools.roles.role.sections.section"
                    ]
                );

                if($user && $user["status"] == true)
                {
                    $data["user"] = $user;
                    unset($data["user"]["schools"]);
                    unset($data["user"]["password"]);

                    if($user["verification"]) $data["verified"] = $user["verification"]["status"];
                    else $data["verified"] = false;

                    unset($data["user"]["verification"]);

                    for($i = 0; $i < count($user["schools"]); $i++)
                    {
                        if($user["schools"][$i]["status"] && $user["schools"][$i]["school"] && $user["schools"][$i]["school"]["status"])
                        {
                            $data["schools"][$i] = $user["schools"][$i]["school"];
                            $data["schools"][$i]["roles"] = [];
                            $data["schools"][$i]["sections"] = [];

                            for($t = 0; $t < count($user["schools"][$i]["roles"]); $t++)
                            {
                                if($user["schools"][$i]["roles"][$t]["role"] && $user["schools"][$i]["roles"][$t]["role"]["status"] && (!$user["schools"][$i]["roles"][$t]["role"]["status"]["user_role"] || ($user["schools"][$i]["roles"][$t]["role"]["status"]["user_role"] && $user["schools"][$i]["roles"][$t]["role"]["status"]["user_role"]["status"])))
                                {
                                    $ln = count($data["schools"][$i]["roles"]);
                                    $data["schools"][$i]["roles"][$ln] = $user["schools"][$i]["roles"][$t]["role"];
                                    unset($data["schools"][$i]["roles"][$ln]["sections"]);
                                    unset($data["schools"][$i]["roles"][$ln]["user_role"]);

                                    for($u = 0; $u < count($user["schools"][$i]["roles"][$t]["role"]["sections"]); $u++)
                                    {
                                        $schoolSection = $user["schools"][$i]["roles"][$t]["role"]["sections"][$u];

                                        if($schoolSection["section"]["status"])
                                        {
                                            $index = $schoolSection["section"]["index"];

                                            if(!isset($data["schools"][$i]["sections"][$index]))
                                            {
                                                $data["schools"][$i]["sections"][$index] = [
                                                    "id" => $schoolSection["section"]["id"],
                                                    "label" => $schoolSection["section"]["label"],
                                                    "index" => $schoolSection["section"]["index"],
                                                    "read" => $schoolSection["read"],
                                                    "create" => $schoolSection["create"],
                                                    "update" => $schoolSection["update"],
                                                    "destroy" => $schoolSection["destroy"]
                                                ];
                                            }
                                            else
                                            {
                                                if($schoolSection['read']) $data["schools"][$i]["sections"][$index]['read'] = 1;

                                                if($schoolSection['create']) $data["schools"][$i]["sections"][$index]['create'] = 1;

                                                if($schoolSection['update']) $data["schools"][$i]["sections"][$index]['update'] = 1;

                                                if($schoolSection['destroy']) $data["schools"][$i]["sections"][$index]['destroy'] = 1;
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }

                    print_r($data);
                }
                else
                {
                    return false;
                }

                /*
                if($user)
                {
                    unset($data["password"]);
                    $userCompany = $user["user_company"];
                    $userAddress = $user["user_address"];

                    unset($user["user_company"]);
                    unset($user["user_address"]);

                    $data["user"] = $user;
                    $data["user"]["company"] = $userCompany;
                    $data["user"]["address"] = $userAddress;

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
                            $userGroups = $this->_userGroup->read([
                                [
                                    'property' => 'id',
                                    'value' => $userGroupUsers[$i]['user_group_id']
                                ]
                            ], true);

                            if($userGroups)
                            {
                                $data['groups'] = array_merge($data['groups'], $userGroups);

                                for($y = 0; $y < count($userGroups); $y++)
                                {
                                    $userGroupRoles = $this->_userGroupRole->read([
                                        [
                                            'property' => 'user_group_id',
                                            'value' => $userGroups[$y]['id']
                                        ]
                                    ]);

                                    if($userGroupRoles)
                                    {
                                        for($z = 0; $z < count($userGroupRoles); $z++)
                                        {
                                            $roles = $this->_userRole->read([
                                                [
                                                    'property' => 'user_role_id',
                                                    'value' => $userGroupRoles[$z]['user_role_id']
                                                ]
                                            ]);

                                            if($roles) $data['roles'] = array_merge($data['roles'], $roles);

                                            $userRolePages = $this->_userRolePage->read([
                                                [
                                                    'property' => 'user_role_id',
                                                    'value' => $userGroupRoles[$z]['user_role_id']
                                                ]
                                            ]);

                                            if($userRolePages)
                                            {
                                                for($u = 0; $u < count($userRolePages); $u++)
                                                {
                                                    $data['pagesUpdate'][] = $this->_page->get($userRolePages[$u]['page_id'], true);
                                                }
                                            }

                                            $userRoleAdminSections = $this->_userRoleAdminSection->read([
                                                [
                                                    'property' => 'user_role_id',
                                                    'value' => $userGroupRoles[$z]['user_role_id']
                                                ]
                                            ]);

                                            if($userRoleAdminSections)
                                            {
                                                for($u = 0; $u < count($userRoleAdminSections); $u++)
                                                {
                                                    $adminSection = $this->_adminSection->get($userRoleAdminSections[$u]['admin_section_id'], true);

                                                    if($adminSection)
                                                    {
                                                        $module = $this->_module->get($adminSection['module_id'], true);

                                                        if($module)
                                                        {
                                                            if(!isset($data['sections'][$adminSection['index']]))
                                                            {
                                                                $data['sections'][$adminSection['index']] = [
                                                                    'read' => $userRoleAdminSections[$u]['read'],
                                                                    'update' => $userRoleAdminSections[$u]['update'],
                                                                    'create' => $userRoleAdminSections[$u]['create'],
                                                                    'destroy' => $userRoleAdminSections[$u]['destroy']
                                                                ];
                                                            }
                                                            else
                                                            {
                                                                if($userRoleAdminSections[$u]['read']) $data['sections'][$module['name_module']]['read'] = 1;

                                                                if($userRoleAdminSections[$u]['read']) $data['sections'][$module['name_module']]['update'] = 1;

                                                                if($userRoleAdminSections[$u]['read']) $data['sections'][$module['name_module']]['create'] = 1;

                                                                if($userRoleAdminSections[$u]['read']) $data['sections'][$module['name_module']]['destroy'] = 1;
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }

                                    $userGroupPages = $this->_userGroupPage->read([
                                        [
                                            'property' => 'user_group_id',
                                            'value' => $userGroups[$y]['id']
                                        ]
                                    ]);

                                    if($userGroupPages)
                                    {
                                        for($u = 0; $u < count($userGroupPages); $u++)
                                        {
                                            $data['pages'][] = $this->_page->get($userGroupPages[$u]['page_id'], true);
                                        }
                                    }
                                }
                            }
                        }
                    }

                    if($user["verification"]) $data["verified"] = $user["verification"]["status"];
                    else $data["verified"] = false;

                    unset($data["user"]["verification"]);

                    return $data;
                }
                else return false;
                */
            }
        );

        if($user) return $user;
        else
        {
            $this->addError("user", "The user doesn't exist.");
            return false;
        }
    }
}
