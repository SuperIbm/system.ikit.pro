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
use Util;
use App\Modules\Access\Actions\AccessGateAction;

/**
 * Класс для определения доступа к школе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateSchool
{
    /**
     * Метод для определения доступа.
     *
     * @param array $user Данные пользователя.
     * @param int $school ID школы.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function check($user, int $school = null): bool
    {
        $school = School::getId() ? School::getId() : $school;
        $accessGateAction = app(AccessGateAction::class);
        $gate = $accessGateAction->addParameter("id", $user["id"])->run();

        if($gate)
        {
            for($i = 0; $i < count($gate["schools"]); $i++)
            {
                if($gate["schools"][$i]["id"] == $school) return true;
            }

            return false;
        }
        else return false;
    }
}
