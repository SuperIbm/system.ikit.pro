<?php
/**
 * Фасады ядра.
 * Этот пакет содержит фасады ядра системы.
 *
 * @package App.Models.Facades
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса для работы с ботом.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Bot extends Facade
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
        return 'bot';
    }
}