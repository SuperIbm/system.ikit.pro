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
 * Класс для определения оплачена ли система пользователем.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GatePaid
{
    /**
     * Метод для определения доступа.
     *
     * @param \App\Modules\User\Models\User $user Данные пользователя.
     * @param bool $status Если указать true, то проверить оплаченность, если false, то неоплаченность.
     * @param int $school ID школы.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function check(User $user, bool $status = true, int $school = null): bool
    {
        $school = School::getId() ? School::getId() : $school;
        $accessGateAction = app(AccessGateAction::class);
        $gate = $accessGateAction->addParameter("id", $user->id)->run();

        if($gate)
        {
            for($i = 0; $i < count($gate["schools"]); $i++)
            {
                if($gate["schools"][$i]["id"] == $school)
                {
                    if($status == true && $gate["schools"][$i]["paid"]) return true;
                    else if($status == false && $gate["schools"][$i]["paid"] == false) return true;
                }
            }

            return false;
        }
        else return false;
    }
}
