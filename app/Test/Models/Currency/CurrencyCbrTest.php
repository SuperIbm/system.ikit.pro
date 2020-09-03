<?php
/**
 * Тестирование ядра базовых классов.
 * Этот пакет содержит набор тестов для ядра баззовых классов.
 *
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Test\Models;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\Currency\CurrencyCbr;

/**
 * Тестирование: Класс драйвер для удаленного получения котировок с центрабанка России.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CurrencyCbrTest extends TestCase
{
    /**
     * Конвертирование из одной кодировки в другую.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testRun(): void
    {
        $currency = new CurrencyCbr();
        $result = $currency->get(Carbon::now(), "USD");

        $this->assertArrayHasKey('value', $result);
    }
}
