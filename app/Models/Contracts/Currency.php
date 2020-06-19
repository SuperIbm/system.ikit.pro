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

use Carbon\Carbon;
use App\Models\Error;

/**
 * Абстрактный класс для проектирования собственной системы котировок.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Currency
{
    use Error;

    /**
     * Получение валюты по коду валюты.
     *
     * @param \Carbon\Carbon $Carbon Дата на которую нужно получить котировки.
     * @param string $charCode Код валюты для получения котировки. Если не указать, то вернет все валюты.
     *
     * @return array|int|false Массив данных запрашиваемой валюты.
     * @since 1.0
     * @version 1.0
     */
    abstract public function get(Carbon $Carbon, $charCode);
}