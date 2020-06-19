<?php
/**
 * Модуль География.
 * Этот модуль содержит все классы для работы с странами, районами, городами и т.д.
 *
 * @package App\Modules\Location
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Location\Contracts;

/**
 * Конрактный класс для создания своего класса позволяющего работать с географическими объектами.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Location
{
    /**
     * Получить все страны.
     *
     * @return array Вернет все страны.
     * @version 1.0
     * @since 1.0
     */
    abstract public function getCountries(): array;

    /**
     * Вернуть название страны по коду.
     *
     * @param string $code Код страны.
     *
     * @return string|bool Название страны.
     * @version 1.0
     * @since 1.0
     */
    abstract public function getNameCountry(string $code);

    /**
     * Получить все регионы страны.
     *
     * @param string $country Код страны.
     *
     * @return array Регионы страны.
     * @version 1.0
     * @since 1.0
     */
    abstract public function getRegions(string $country): array;

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
    abstract public function getNameRegion(string $country, string $code);

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
    abstract public function getCities(string $country, string $region): array;

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
    abstract public function getNameCity(string $country, string $region, string $code);
}
