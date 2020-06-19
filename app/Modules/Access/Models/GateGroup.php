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

use Util;
use App\Modules\Access\Actions\AccessGateAction;

/**
 * Класс для определения доступа к страницам сайта через группу.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateGroup
{
    /**
     * Метод для определения доступа.
     *
     * @param array $user Данные пользователя.
     * @param string $nameGroup Название группы.
     *
     * @return bool Вернет true, если есть доступ.
     * @version 1.0
     * @since 1.0
     */
    public function check($user, $nameGroup)
    {
        $nameGroups = explode(":", $nameGroup);

        $accessGateAction = app(AccessGateAction::class);
        $gates = $accessGateAction->addParameter("id", $user["id"])->run();

        for($i = 0; $i < count($gates["groups"]); $i++)
        {
            for($y = 0; $y < count($nameGroups); $y++)
            {
                if($gates["groups"][$i]["name_group"] == $nameGroups[$y]) return true;
            }
        }

        return false;
    }
}