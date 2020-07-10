<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\User\Events\Listeners;

use App\Modules\User\Models\UserSchool;

/**
 * Класс обработчик событий для модели соотношений пользователей к школам.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserSchoolListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\User\Models\UserSchool $userSchool Модель для таблицы соотношений пользователя к школе.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(UserSchool $userSchool)
    {
        $userSchool->deleteRelation($userSchool->roles(), $userSchool->isForceDeleting());

        return true;
    }
}
