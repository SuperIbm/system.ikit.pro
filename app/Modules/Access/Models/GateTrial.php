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
 * Класс для определения находиться ли система в пробной версии.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateTrial
{
    /**
     * Метод для определения доступа.
     *
     * @param \App\Modules\User\Models\User $user Данные пользователя.
     * @param int $school ID школы.
     * @param bool $trial Если указать true, то проверить что это пробная версия, если false, то не пробная.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function check(User $user, bool $trial = true, int $school = null): bool
    {
        $school = School::getId() ? School::getId() : $school;
        $accessGateAction = app(AccessGateAction::class);
        $gate = $accessGateAction->addParameter("id", $user->id)->run();

        if($gate)
        {
            for($i = 0; $i < count($gate["schools"]); $i++)
            {
                if($gate["schools"][$i]["id"] == $school && $gate["schools"][$i]["paid"]) return ($gate["schools"][$i]["paid"]["trial"] == $trial);
            }

            return false;
        }
        else return false;
    }
}
