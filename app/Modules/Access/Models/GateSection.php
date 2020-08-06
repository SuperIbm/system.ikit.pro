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
use School;
use App\Modules\User\Models\User;

/**
 * Класс для определения доступа к разделам системы.
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
     * @param \App\Modules\User\Models\User $user Данные пользователя.
     * @param string $section Название секции системы.
     * @param string $type Тип доступа: read, create, update, destroy.
     * @param int $school ID школы.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function check(User $user, string $section, string $type, int $school = null): bool
    {
        $school = School::getId() ? School::getId() : $school;
        $sections = explode(":", $section);

        $accessGateAction = app(AccessGateAction::class);
        $gate = $accessGateAction->addParameter("id", $user->id)->run();

        if($gate)
        {
            for($i = 0; $i < count($gate["schools"]); $i++)
            {
                if($gate["schools"][$i]["id"] == $school)
                {
                    for($z = 0; $z < count($sections); $z++)
                    {
                        if(isset($gate["schools"][$i]["sections"][$sections[$z]][$type]) && $gate["schools"][$i]["sections"][$sections[$z]][$type] == true) return true;
                    }
                }
            }

            return false;
        }
        else return false;
    }
}
