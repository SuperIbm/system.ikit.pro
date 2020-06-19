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
     * @param string $geoObject Название геообъекта для получения.
     * Доступные значения:
     * <ul>
     *  <li>inetnum - IP подсети</li>
     *  <li>country - страна</li>
     *  <li>city - город</li>
     *  <li>region - регион</li>
     *  <li>district - округ</li>
     *  <li>lat - долгота</li>
     *  <li>lng - широта</li>
     * <ul>
     * Если не указать, то вернет массив со всеми данными.
     * @param string $ip IP пользователя. Если не указать, получить IP текущего пользователя.
     *
     * @return string|array|false Вернет значения по указанным параметрам.
     * @since 1.0
     * @version 1.0
     */
    abstract public function get($geoObject = null, $ip = null);
}