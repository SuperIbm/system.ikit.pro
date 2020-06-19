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
 * Класс для определения доступа к разделам административной системы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GateSection
{
    /**
     * Метод для определения доступа.
     *
     * @param array $user Данные пользователя.
     * @param string $section Название секции админстративной системы.
     * @param string $type Тип доступа: read, create, update, destroy.
     *
     * @return bool Вернет true, если есть доступ.
     * @version 1.0
     * @since 1.0
     */
    public function check($user, $section, $type)
    {
        $sections = explode(":", $section);

        $accessGateAction = app(AccessGateAction::class);
        $gates = $accessGateAction->addParameter("id", $user["id"])->run();

        for($i = 0; $i < count($sections); $i++)
        {
            if(isset($gates["sections"][$sections[$i]][$type]) && $gates["sections"][$sections[$i]][$type] == true) return true;
        }

        return false;
    }
}