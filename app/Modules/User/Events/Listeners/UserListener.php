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

use App\Modules\User\Models\User;
use ImageStore;

/**
 * Класс обработчик событий для модели пользователей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\User\Models\User $user Модель для таблицы пользователей.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(User $user)
    {
        if($user->image_small_id) ImageStore::destroy($user->image_small_id["id"]);
        if($user->image_middle_id) ImageStore::destroy($user->image_middle_id["id"]);

        $user->deleteRelation($user->userGroupRoles());
        $user->deleteRelation($user->verification());
        $user->deleteRelation($user->recovery());
        $user->deleteRelation($user->orderUsers());
        $user->deleteRelation($user->userCompany());
        $user->deleteRelation($user->userAddress());

        return true;
    }
}