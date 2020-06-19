<?php
/**
 * Модуль Запоминания действий.
 * Этот модуль содержит все классы для работы с запоминанием и контролем действий пользователя.
 *
 * @package App\Modules\Act
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Act\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса запоминания действий пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Act extends Facade
{
    /**
     * Получить зарегистрированное имя компонента.
     *
     * @return string
     * @version 1.0
     * @since 1.0
     */
    protected static function getFacadeAccessor()
    {
        return 'act';
    }
}