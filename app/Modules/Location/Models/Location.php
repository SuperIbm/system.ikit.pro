<?php
/**
 * Модуль География.
 * Этот модуль содержит все классы для работы с странами, районами, городами и т.д.
 *
 * @package App\Modules\Location
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Location\Models;

use Geographer;
use App\Modules\Order\Models\OrderDeliveryZone;
use Util;
use Cache;
use App\Modules\Location\Contracts\Location as Contract;

/**
 * Класс для работы с географическими объектами.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Location extends Contract
{
    /**
     * Получить все страны.
     *
     * @return array Вернет все страны.
     * @version 1.0
     * @since 1.0
     */
    public function getCountries(): array
    {
        $key = Util::getKey("Geographer", "Location", "getCountries");

        $countries = Cache::tags(["Gallery"])->remember($key, 60 * 24 * 30, function()
        {
            $countries = Geographer::getCountries()->toArray();
            $data = [];

            for($i = 0; $i < count($countries); $i++)
            {
                $data[$countries[$i]["code"]] = $countries[$i]["name"];
            }

            return $data;
        });

        return $countries;
    }

    /**
     * Получить все допустимые страны.
     *
     * @param bool $showAll Вернуть все страны.
     *
     * @return array|bool Вернет все допустимые страны.
     * @version 1.0
     * @since 1.0
     */
    public function getAllowedCountries($showAll = true)
    {
        $orderDeliveryZones = OrderDeliveryZone::orderBy("weight", "ASC")->get()->unique('code');

        if($orderDeliveryZones->count())
        {
            $data = [];

            foreach($orderDeliveryZones as $orderDeliveryZone)
            {
                $data[$orderDeliveryZone->code] = [
                    "name" => $orderDeliveryZone->name,
                    "telephone_format" => $orderDeliveryZone->telephone_format,
                ];
            }

            return $data;
        }
        else if($showAll) return Location::getCountries();
        else return false;
    }

    /**
     * Вернуть название страны по коду.
     *
     * @param string $code Код страны.
     *
     * @return string|bool Название страны.
     * @version 1.0
     * @since 1.0
     */
    public function getNameCountry(string $code)
    {
        $countries = Location::getCountries();

        if(isset($countries[$code])) return $countries[$code];
        else return false;
    }

    /**
     * Получить все регионы страны.
     *
     * @param string $country Код страны.
     *
     * @return array Регионы страны.
     * @version 1.0
     * @since 1.0
     */
    public function getRegions(string $country): array
    {
        $key = Util::getKey("Geographer", "Location", "getRegions", $country);

        $regions = Cache::tags(["Gallery"])->remember($key, 60 * 24 * 30, function() use ($country)
        {
            $stages = Geographer::getCountries()->findOne(["code" => $country])->getStates()->toArray();
            $regions = [];

            for($i = 0; $i < count($stages); $i++)
            {
                $regions[$stages[$i]["isoCode"]] = $stages[$i]["name"];
            }

            return $regions;
        });

        return $regions;
    }

    /**
     * Получить название региона по коду региона.
     *
     * @param string $country Код страны.
     * @param string $code Код региона.
     *
     * @return string|bool Регионы страны.
     * @version 1.0
     * @since 1.0
     */
    public function getNameRegion(string $country, string $code)
    {
        $regions = Location::getRegions($country);

        if(isset($regions[$code])) return $regions[$code];
        else return false;
    }

    /**
     * Получить все города по стране и региону.
     *
     * @param string $country Код страны.
     * @param string $region Код региона.
     *
     * @return array Города страны и его региона.
     * @version 1.0
     * @since 1.0
     */
    public function getCities(string $country, string $region): array
    {
        $key = Util::getKey("Geographer", "Location", "getCities", $country, $region);

        $cities = Cache::tags(["Gallery"])->remember($key, 60 * 24 * 30, function() use ($country, $region)
        {
            $cities = Geographer::getCountries()
                ->findOne(["code" => $country])
                ->getStates()
                ->findOne(["isoCode" => $region])
                ->getCities()
                ->toArray();

            $data = [];

            for($i = 0; $i < count($cities); $i++)
            {
                $data[$cities[$i]["code"]] = $cities[$i]["name"];
            }

            return $data;
        });

        return $cities;
    }

    /**
     * Получить название города по его коду.
     *
     * @param string $country Код страны.
     * @param string $region Код региона.
     * @param string $code Код города.
     *
     * @return array|bool Название города.
     * @version 1.0
     * @since 1.0
     */
    public function getNameCity(string $country, string $region, string $code)
    {
        $cities = Location::getCities($country, $region);

        if(isset($cities[$code])) return $cities[$code];
        else return false;
    }
}