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
 * Абстрактный класс для проектирования собственной системы геокодирования.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Geocoder
{
    use Error;

    /**
     * Абстрактный метод для получения координат на основе адреса.
     *
     * @param string $zipCode Индекс.
     * @param string $country Страна.
     * @param string $city Город.
     * @param string $region Регион.
     * @param string $street Уличца.
     *
     * @return array|bool Вернет кооридинату местоположения.
     * @since 1.0
     * @version 1.0
     */
    abstract public function get(string $zipCode = null, string $country = null, string $city = null, string $region = null, string $street = null);

    /**
     * Получение адреса.
     *
     * @param string $zipCode Индекс.
     * @param string $country Страна.
     * @param string $city Город.
     * @param string $region Регион.
     * @param string $street Уличца.
     *
     * @return string|boolean Вернет строку адреса.
     * @since 1.0
     * @version 1.0
     */
    protected function _getAddress(string $zipCode = null, string $country = null, string $city = null, string $region = null, string $street = null)
    {
        $address = '';

        if($zipCode) $address .= $zipCode;

        if($country)
        {
            if($address) $address .= ', ';

            $address .= $country;
        }

        if($region)
        {
            if($address) $address .= ', ';

            $address .= $region;
        }

        if($city)
        {
            if($address) $address .= ', ';

            $address .= $city;
        }

        if($street)
        {
            if($address) $address .= ', ';

            $address .= $street;
        }

        return $address ? $address : false;
    }
}
