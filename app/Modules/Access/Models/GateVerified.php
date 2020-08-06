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

use App\Modules\Access\Actions\AccessGateAction;
use App\Modules\User\Models\User;

/**
 * Класс для определения верифицаирован ли пользователь или нет.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateVerified
{
    /**
     * Метод для определения доступа.
     *
     * @param \App\Modules\User\Models\User $user Данные пользователя.
     * @param bool $verified Если указать true то проверит что пользователь верифицирован, если false, то нет.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function check(User $user, bool $verified = true): bool
    {
        $accessGateAction = app(AccessGateAction::class);
        $gate = $accessGateAction->addParameter("id", $user->id)->run();

        if($gate)
        {
            if($verified) return $gate["verified"] == true;
            else return $gate["verified"] == false;
        }
        else return false;
    }
}
