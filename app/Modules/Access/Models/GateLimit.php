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

/**
 * Класс для определения лимитов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateLimit
{
    /**
     * Метод для определения доступа.
     *
     * @param array $user Данные пользователя.
     * @param string $name Название лимита.
     * @param int $value Значение для проверки.
     * @param int $school ID школы.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function check($user, string $name, int $value, int $school = null): bool
    {
        $school = School::getId() ? School::getId() : $school;
        $accessGateAction = app(AccessGateAction::class);
        $gate = $accessGateAction->addParameter("id", $user["id"])->run();

        if($gate)
        {
            for($i = 0; $i < count($gate["schools"]); $i++)
            {
                if($gate["schools"][$i]["id"] == $school)
                {
                    for($z = 0; $z < count($gate["schools"][$i]["limits"]); $z++)
                    {
                        if($gate["schools"][$i]["limits"][$z]["type"] == $name) return $gate["schools"][$i]["limits"][$z]["remain"] >= $value;
                    }

                    break;
                }
            }

            return false;
        }
        else return false;
    }
}
