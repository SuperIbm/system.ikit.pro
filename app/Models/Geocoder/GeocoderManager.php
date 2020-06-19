<?php
/**
 * Геокодирование.
 * Пакет содержит классы для получения местоположения пользователя по его IP.
 *
 * @package App.Models.Geocoder
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Geocoder;

use Illuminate\Support\Manager;


/**
 * Класс системы геокодирования.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeocoderManager extends Manager
{
    /**
     * @see \Illuminate\Support\Manager::getDefaultDriver
     */
    public function getDefaultDriver()
    {
        return $this->app['config']['geocoder.driver'];
    }
}