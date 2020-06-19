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
use App\Modules\User\Repositories\UserGroupUser;
use App\Modules\User\Repositories\UserGroup;
use App\Modules\User\Repositories\UserGroupRole;
use App\Modules\User\Repositories\UserGroupPage;
use App\Modules\User\Repositories\UserRole;
use App\Modules\User\Repositories\UserRolePage;
use App\Modules\User\Repositories\UserRoleAdminSection;
use App\Modules\AdminSection\Repositories\AdminSection;
use App\Modules\Page\Repositories\Page;
use App\Modules\Module\Repositories\Module;

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
     * Репозитарий групп пользователя.
     *
     * @var \App\Modules\User\Repositories\UserGroupUser
     * @version 1.0
     * @since 1.0
     */
    private $_userGroupUser;

    /**
     * Репозитарий групп.
     *
     * @var \App\Modules\User\Repositories\UserGroup
     * @version 1.0
     * @since 1.0
     */
    private $_userGroup;

    /**
     * Репозитарий групп ролей.
     *
     * @var \App\Modules\User\Repositories\UserGroupRole
     * @version 1.0
     * @since 1.0
     */
    private $_userGroupRole;

    /**
     * Репозитарий групп страниц.
     *
     * @var \App\Modules\User\Repositories\UserGroupPage
     * @version 1.0
     * @since 1.0
     */
    private $_userGroupPage;

    /**
     * Репозитарий ролей.
     *
     * @var \App\Modules\User\Repositories\UserRole
     * @version 1.0
     * @since 1.0
     */
    private $_userRole;

    /**
     * Репозитарий страниц ролей.
     *
     * @var \App\Modules\User\Repositories\UserRolePage
     * @version 1.0
     * @since 1.0
     */
    private $_userRolePage;

    /**
     * Репозитарий разделов административной системы в ролях.
     *
     * @var \App\Modules\User\Repositories\UserRoleAdminSection
     * @version 1.0
     * @since 1.0
     */
    private $_userRoleAdminSection;

    /**
     * Репозитарий разделов административной системы.
     *
     * @var \App\Modules\AdminSection\Repositories\AdminSection
     * @version 1.0
     * @since 1.0
     */
    private $_adminSection;

    /**
     * Репозитарий страниц.
     *
     * @var \App\Modules\Page\Repositories\Page
     * @version 1.0
     * @since 1.0
     */
    private $_page;

    /**
     * Репозитарий модулей.
     *
     * @var \App\Modules\Module\Repositories\Module
     * @version 1.0
     * @since 1.0
     */
    private $_module;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserGroupUser $userGroupUser Репозитарий групп пользователя.
     * @param \App\Modules\User\Repositories\UserGroup $userGroup Репозитарий групп.
     * @param \App\Modules\User\Repositories\UserGroupRole $userGroupRole Репозитарий групп ролей.
     * @param \App\Modules\User\Repositories\UserGroupPage $userGroupPage Репозитарий групп страниц.
     * @param \App\Modules\User\Repositories\UserRole $userRole Репозитарий ролей.
     * @param \App\Modules\User\Repositories\UserRolePage $userRolePage Репозитарий страниц ролей.
     * @param \App\Modules\User\Repositories\UserRoleAdminSection $userRoleAdminSection Репозитарий разделов административной системы в ролях.
     * @param \App\Modules\AdminSection\Repositories\AdminSection $adminSection Репозитарий разделов административной системы.
     * @param \App\Modules\Page\Repositories\Page $page Репозитарий страниц.
     * @param \App\Modules\Module\Repositories\Module $module Репозитарий модулей.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserGroupUser $userGroupUser, UserGroup $userGroup, UserGroupRole $userGroupRole, UserGroupPage $userGroupPage, UserRole $userRole, UserRolePage $userRolePage, UserRoleAdminSection $userRoleAdminSection, AdminSection $adminSection, Page $page, Module $module)
    {
        $this->_user = $user;
        $this->_userGroupUser = $userGroupUser;
        $this->_userGroup = $userGroup;
        $this->_userGroupRole = $userGroupRole;
        $this->_userGroupPage = $userGroupPage;
        $this->_userRole = $userRole;
        $this->_userRolePage = $userRolePage;
        $this->_userRoleAdminSection = $userRoleAdminSection;
        $this->_adminSection = $adminSection;
        $this->_page = $page;
        $this->_module = $module;
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

        $user = Cache::tags(["User", "UserItem"])->remember($key, 60 * 24 * 30,
            function() use ($id)
            {
                $data = [
                    'user' => [],
                    'sections' => [],
                    'pages' => [],
                    'pagesUpdate' => [],
                    'roles' => [],
                    'groups' => [],
                    'verified' => false
                ];

                $user = $this->_user->get($id, true,
                    [
                        "verification",
                        "userCompany",
                        "userAddress"
                    ]
                );

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
