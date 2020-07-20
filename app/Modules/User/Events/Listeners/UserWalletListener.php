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

use App\Modules\User\Models\UserWallet;

/**
 * Класс обработчик событий для модели кошелька.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserWalletListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\User\Models\UserWallet $userWaller Модель кошелька.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(UserWallet $userWaller)
    {
        $userWaller->deleteRelation($userWaller->inputs(), $userWaller->isForceDeleting());
        $userWaller->deleteRelation($userWaller->outputs(), $userWaller->isForceDeleting());

        return true;
    }
}
