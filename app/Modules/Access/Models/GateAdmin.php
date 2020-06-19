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
 * Класс для определения доступа к страницам сайта через проверку является ли этот пользователь администратором.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateAdmin
{
    /**
     * Метод для определения доступа.
     *
     * @param array $user Данные пользователя.
     * @param bool $status Если указать true, то значит нужно проверить истенность, что это администратор, если false, то значит ложность.
     *
     * @return bool Вернет true, если есть доступ.
     * @version 1.0
     * @since 1.0
     */
    public function check($user, $status = true)
    {
        $accessGateAction = app(AccessGateAction::class);
        $gates = $accessGateAction->addParameter("id", $user["id"])->run();

        if((count($gates["roles"]) && $status == true) || (count($gates["roles"]) == 0 && $status == false)) return true;
        else return false;
    }
}