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

use App\Modules\OAuth\Models\OAuthClientEloquent;

/**
 * Класс обработчик событий для модели модулей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OAuthClientEloquentListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\OAuth\Models\OAuthClientEloquent $oAuthClientEloquent Модель для клиентов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(OAuthClientEloquent $oAuthClientEloquent)
    {
        $oAuthClientEloquent->deleteRelation($oAuthClientEloquent->tokens());

        return true;
    }
}