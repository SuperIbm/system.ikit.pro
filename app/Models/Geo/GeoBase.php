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

use App\Models\Contracts\Geo;
use Request;

/**
 * Класс драйвер геопозиционирования на основе сервиса ipgeobase.ru.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeoBase extends Geo
{
    /**
     * Метод для получения геообъекта.
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
     * @see \App\Models\Contracts\Geo::get
     */
    public function get($geoObject = null, $ip = null)
    {
        $ip = isset($ip) ? $ip : Request::ip();
        $keyArray = ['inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng'];

        if(!in_array($geoObject, $keyArray)) $geoObject = null;

        $ch = curl_init('http://ipgeobase.ru:7020/geo?ip=' . $ip);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 3);
        $string = curl_exec($ch);

        $string = iconv('windows-1251', "utf-8", $string);

        $params = ['inetnum', 'country', 'city', 'region', 'district', 'lat', 'lng'];
        $data = $out = [];

        foreach($params as $param)
        {
            if(preg_match('#<' . $param . '>(.*)</' . $param . '>#is', $string, $out)) $data[$param] = trim($out[1]);
        }

        if($geoObject && isset($data[$geoObject])) return $data[$geoObject];

        return $data;
    }
}