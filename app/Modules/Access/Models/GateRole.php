<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Models;

use School;
use App\Modules\Access\Actions\AccessGateAction;
use App\Modules\User\Models\User;

/**
 * Класс для определения доступа к страницам сайта через роль.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateRole
{
    /**
     * Метод для определения доступа.
     *
     * @param \App\Modules\User\Models\User $user Данные пользователя.
     * @param array|string Название ролей.
     * @param int $school ID школы.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function check(User $user, $nameRoles, int $school = null): bool
    {
        if(is_string($nameRoles)) $nameRoles = explode(":", $nameRoles);

        $school = School::getId() ? School::getId() : $school;

        $accessGateAction = app(AccessGateAction::class);
        $gate = $accessGateAction->addParameter("id", $user->id)->run();

        if($gate)
        {
            for($i = 0; $i < count($gate["schools"]); $i++)
            {
                if($gate["schools"][$i]["id"] == $school)
                {
                    for($z = 0; $z < count($gate["schools"][$i]["roles"]); $z++)
                    {
                        for($y = 0; $y < count($nameRoles); $y++)
                        {
                            if($gate["schools"][$i]["roles"][$z]["name"] == $nameRoles[$y]) return true;
                        }
                    }
                }
            }

            return false;
        }
        else return false;
    }
}
