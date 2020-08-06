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

/**
 * Класс для определения доступа к страницам сайта.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateUser
{
    /**
     * Метод для определения доступа.
     *
     * @param array $user Данные пользователя.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function check(array $user): bool
    {
        $accessGateAction = app(AccessGateAction::class);
        $gates = $accessGateAction->addParameter("id", $user["id"])->run();

        if($gates) return true;
        else return false;
    }
}
