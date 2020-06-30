<?php
/**
 * Геопозиционирование.
 * Пакет содержит классы для получения местоположения пользователя по его IP.
 *
 * @package App.Models.Geo
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Geo;

use Config;
use Illuminate\Support\Manager;

/**
 * Класс системы геопозиционирования.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeoManager extends Manager
{
    /**
     * @see \Illuminate\Support\Manager::getDefaultDriver
     */
    public function getDefaultDriver()
    {
        return Config::get('geo.driver');
    }
}
