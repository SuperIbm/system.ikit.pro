<?php
/**
 * Котировки валют.
 * Пакет содержит классы для получения котировок валют.
 *
 * @package App.Models.Currency
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Currency;

use Config;
use Illuminate\Support\Manager;

/**
 * Класс системы котировок для получения курсов валют.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CurrencyManager extends Manager
{
    /**
     * @see \Illuminate\Support\Manager::getDefaultDriver
     */
    public function getDefaultDriver()
    {
        return Config::get('currency.driver');
    }
}
