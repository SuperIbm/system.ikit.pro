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

use Config;
use App\Models\Contracts\Geocoder;

/**
 * Класс драйвер геокодирования на основе сервиса Google.com.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeocoderGoogle extends Geocoder
{
    /**
     * Метод для получения координат на основе адреса.
     *
     * @param string $zipCode Индекс.
     * @param string $country Страна.
     * @param string $city Город.
     * @param string $region Регион.
     * @param string $street Уличца.
     *
     * @return array|false Вернет кооридинату местоположения.
     * @since 1.0
     * @version 1.0
     */
    public function get(string $zipCode = null, string $country = null, string $city = null, string $region = null, string $street = null)
    {
        $address = $this->_getAddress($zipCode, $country, $city, $region, $street);

        if($address)
        {
            $url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode($address).'&key=' . Config::get("map.key");
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 3);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
            $data = curl_exec($ch);
            $data = json_decode($data, true);

            if($data["status"] == "OK")
            {
                return [
                    "latitude" => $data["results"][0]["geometry"]["location"]['lat'],
                    "longitude" => $data["results"][0]["geometry"]["location"]['lng']
                ];
            }
            else
            {
                $this->addError($data["status"], $data["error_message"]);
                return false;
            }
        }
        else return false;
    }
}