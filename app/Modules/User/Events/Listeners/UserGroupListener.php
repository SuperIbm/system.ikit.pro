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

use App\Modules\User\Models\UserGroup;

/**
 * Класс обработчик событий для модели групп пользователей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserGroupListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\User\Models\UserGroup $userGroup Модель для таблицы групп пользователей.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(UserGroup $userGroup)
    {
        $userGroup->deleteRelation($userGroup->userGroupUsers(), $userGroup->isForceDeleting());
        $userGroup->deleteRelation($userGroup->userGroupPage(), $userGroup->isForceDeleting());
        $userGroup->deleteRelation($userGroup->userGroupRoles(), $userGroup->isForceDeleting());

        return true;
    }
}