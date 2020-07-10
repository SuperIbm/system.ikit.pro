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

use App\Modules\User\Models\UserRole;

/**
 * Класс обработчик событий для модели ролей пользователей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserRoleListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\User\Models\UserRole $userRole Модель для таблицы ролей пользователей.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(UserRole $userRole)
    {
        $userRole->deleteRelation($userRole->schoolRoles(), $userRole->isForceDeleting());

        return true;
    }
}
