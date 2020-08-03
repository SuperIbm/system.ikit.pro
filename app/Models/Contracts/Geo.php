<?php
/**
 * Контракты.
 * Этот пакет содержит контракты ядра системы.
 *
 * @package App.Models.Contracts
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Contracts;

use App\Models\Error;

/**
 * Абстрактный класс для проектирования собственной системы геопозиционирования.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Geo
{
    use Error;

    /**
     * Абстрактный метод для получения геообъекта.
     *
     * @param string $ip IP пользователя. Если не указать, получить IP текущего пользователя.
     *
     * @return string|array|bool Вернет значения по указанным параметрам.
     * @since 1.0
     * @version 1.0
     */
    abstract public function get(string $ip = null);
}
