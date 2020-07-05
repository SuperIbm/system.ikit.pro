<?php
/**
 * Модуль API аутентификации.
 * Этот модуль содержит все классы для работы с API аутентификации.
 *
 * @package App\Modules\OAuth
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\OAuth\Events\Listeners;

use App\Modules\OAuth\Models\OAuthTokenEloquent;

/**
 * Класс обработчик событий для модели токенов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OAuthTokenEloquentListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\OAuth\Models\OAuthTokenEloquent $oAuthTokenEloquent Модель для токенов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(OAuthTokenEloquent $oAuthTokenEloquent)
    {
        $oAuthTokenEloquent->deleteRelation($oAuthTokenEloquent->refreshToken(), $oAuthTokenEloquent->isForceDeleting());

        return true;
    }
}
