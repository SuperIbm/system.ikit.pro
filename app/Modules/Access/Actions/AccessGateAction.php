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
use Carbon\Carbon;
use Util;
use App\Models\Action;
use App\Modules\User\Repositories\User;

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
    private User $_user;

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

        $user = Cache::tags(["User", "UserItem"])->remember($key, 60 * 24 * 30, function() use ($id) {
            $data = [
                'user' => [],
                'schools' => [],
                'verified' => false
            ];

            $user = $this->_user->get($id, true, null, [
                "verification",
                "schools.school.plan",
                "schools.school.limits.planLimit",
                "schools.school.activeOrders.orderable",
                "schools.roles.role.userRole",
                "schools.roles.role.sections.section",
                "wallet"
            ]);

            if($user && $user["status"] == true)
            {
                $data["user"] = $this->_getUser($user);
                $data["verified"] = $this->_getVerified($user["verification"]);
                $data["schools"] = $this->_getSchools($user["schools"]);

                return $data;
            }
            else return false;
        });

        if($user) return $this->_checkDates($user);
        else
        {
            $this->addError("user", trans('access::actions.accessGateAction.not_exist_user'));
            return false;
        }
    }

    /**
     * Проверим даты которые валидны по времени.
     *
     * @param array $user Массив данных пользователя.
     *
     * @return array Вернет массив данных пользователей.
     * @since 1.0
     * @version 1.0
     */
    private function _checkDates(array $user): array
    {
        for($i = 0; $i < count($user["schools"]); $i++)
        {
            $limits = [];

            for($t = 0; $t < count($user["schools"][$i]["limits"]); $t++)
            {
                if(Carbon::now() >= $user["schools"][$i]["limits"][$t]["from"] && ($user["schools"][$i]["limits"][$t]["to"] == null || $user["schools"][$i]["limits"][$t]["to"] >= Carbon::now()))
                {
                    $limits[] = $user["schools"][$i]["limits"][$t];
                }
            }

            $user["schools"][$i]["limits"] = $limits;

            if(isset($user["schools"][$i]["paid"]))
            {
                if(Carbon::now() < $user["schools"][$i]["paid"]["from"] || ($user["schools"][$i]["paid"]["to"] && Carbon::now() >= $user["schools"][$i]["paid"]["to"]))
                {
                    $user["schools"][$i]["paid"] = false;
                }
            }
        }

        return $user;
    }

    /**
     * Получить данные о пользователе.
     *
     * @param array $user Массив данных пользователя.
     *
     * @return array Вернет массив данных о пользователе.
     * @since 1.0
     * @version 1.0
     */
    private function _getUser(array $user): array
    {
        unset($user["schools"]);
        unset($user["password"]);
        unset($user["verification"]);

        return $user;
    }

    /**
     * Получить статус верификации.
     *
     * @param array $verification Данные верификации.
     *
     * @return bool Вернет статус верификации.
     * @since 1.0
     * @version 1.0
     */
    private function _getVerified(array $verification): bool
    {
        if($verification) return $verification["status"];
        else return false;
    }

    /**
     * Получить массив школ с параметрами школы.
     *
     * @param array $schools Массив школ с их данными.
     *
     * @return array Вернет массив школ с их параметрами.
     * @since 1.0
     * @version 1.0
     */
    private function _getSchools(array $schools): array
    {
        $result = [];

        for($i = 0; $i < count($schools); $i++)
        {
            if($schools[$i]["status"] && $schools[$i]["school"] && $schools[$i]["school"]["status"])
            {
                $lng = count($result);
                $result[$lng] = $schools[$i]["school"];
                $result[$lng]["roles"] = $this->_getRoles($schools[$i]["roles"]);
                $result[$lng]["sections"] = $this->_getSections($schools[$i]["roles"]);
                $result[$lng]["paid"] = $this->_getPaid($schools[$i]["school"]["active_orders"]);
                $result[$lng]["limits"] = $this->_getLimits($schools[$i]["school"]["limits"], $schools[$i]["school"]["active_orders"]);

                unset($result[$lng]["active_orders"]);
            }
        }

        return $result;
    }

    /**
     * Получить параметры оплаченного сервиса.
     *
     * @param array $activeOrders Массив активных заказов.
     *
     * @return array|bool Вернет массив параметра оплаты либо false если оплаты нет.
     * @since 1.0
     * @version 1.0
     */
    private function _getPaid(array $activeOrders)
    {
        if(isset($activeOrders))
        {
            $paid = null;

            for($t = 0; $t < count($activeOrders); $t++)
            {
                if($activeOrders[$t]["type"] == "system")
                {
                    $paid = [
                        "name" => $activeOrders[$t]["name"],
                        "from" => $activeOrders[$t]["from"],
                        "to" => $activeOrders[$t]["to"],
                        "trial" => $activeOrders[$t]["trial"],
                    ];
                }
            }

            if($paid) return $paid;
            else return false;
        }
        else return false;
    }

    /**
     * Получить оплаченный заказ лимита.
     *
     * @param string $type Тип лимита.
     * @param array $activeOrders Массив активных заказов.
     *
     * @return array|bool Вернет данные о заказе либо false если заказа нет.
     * @since 1.0
     * @version 1.0
     */
    private function _getLimitOrder(string $type, array $activeOrders)
    {
        for($i = 0; $i < count($activeOrders); $i++)
        {
            if($activeOrders[$i]["type"] == $type) return $activeOrders[$i];
        }

        return false;
    }

    /**
     * Получить лимиты школы.
     *
     * @param array $limits Массив лимитов.
     * @param array $activeOrders Массив активных заказов.
     *
     * @return array Вернет массив лимитов.
     * @since 1.0
     * @version 1.0
     */
    private function _getLimits(array $limits, array $activeOrders): array
    {
        $result = [];

        for($i = 0; $i < count($limits); $i++)
        {
            $order = $this->_getLimitOrder($limits[$i]["plan_limit"]["type"], $activeOrders);

            if($order)
            {
                if($limits[$i]["plan_limit"] && $limits[$i]["plan_limit"]["status"])
                {
                    $result[] = [
                        "name" => $limits[$i]["plan_limit"]["name"],
                        "description" => $limits[$i]["plan_limit"]["description"],
                        "type" => $limits[$i]["plan_limit"]["type"],
                        "unit" => $limits[$i]["plan_limit"]["unit"],
                        "limit" => $limits[$i]["limit"],
                        "remain" => $limits[$i]["remain"],
                        "from" => $order["from"],
                        "to" => $order["to"],
                        "trial" => $order["trial"],
                    ];
                }
            }
        }

        return $result;
    }

    /**
     * Проверка статуса роли.
     *
     * @param array $role Масси данных роли.
     *
     * @return bool Вернет статус проверки.
     * @since 1.0
     * @version 1.0
     */
    private function _isRoleStatus(array $role): bool
    {
        return $role && $role["status"] && (!$role["status"]["user_role"] || ($role["status"]["user_role"] && $role["status"]["user_role"]["status"]));
    }

    /**
     * Получить массив ролей пользователя.
     *
     * @param array $roles Массив данных о ролях.
     *
     * @return array Вернет массив ролей.
     * @since 1.0
     * @version 1.0
     */
    private function _getRoles(array $roles): array
    {
        $result = [];

        for($t = 0; $t < count($roles); $t++)
        {
            if($this->_isRoleStatus($roles[$t]["role"]))
            {
                $ln = count($result);
                $result[$ln] = $roles[$t]["role"];
                unset($result[$ln]["sections"]);
                unset($result[$ln]["user_role"]);
            }
        }

        return $result;
    }

    /**
     * Получить массив разделов и их доступов.
     *
     * @param array $roles Массив данных о ролях.
     *
     * @return array Вернет массив разделов с доступами.
     * @since 1.0
     * @version 1.0
     */
    private function _getSections(array $roles): array
    {
        $sections = [];

        for($t = 0; $t < count($roles); $t++)
        {
            if($this->_isRoleStatus($roles[$t]["role"]))
            {
                for($u = 0; $u < count($roles[$t]["role"]["sections"]); $u++)
                {
                    $schoolSection = $roles[$t]["role"]["sections"][$u];

                    if($schoolSection["section"]["status"])
                    {
                        $index = $schoolSection["section"]["index"];

                        if(!isset($sections[$index]))
                        {
                            $sections[$index] = [
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
                            if($schoolSection['read']) $sections[$index]['read'] = 1;

                            if($schoolSection['create']) $sections[$index]['create'] = 1;

                            if($schoolSection['update']) $sections[$index]['update'] = 1;

                            if($schoolSection['destroy']) $sections[$index]['destroy'] = 1;
                        }
                    }
                }
            }
        }

        return $sections;
    }
}
