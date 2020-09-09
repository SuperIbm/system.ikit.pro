<?php
/**
 * Тестирование ядра базовых классов.
 * Этот пакет содержит набор тестов для ядра баззовых классов.
 *
 * @package App.Tests.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Tests\Models\Geo;

use Tests\TestCase;
use App\Models\Geo\GeoBase;

/**
 * Тестирование: Класс драйвер геопозиционирования на основе сервиса ipgeobase.ru.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeoBaseTest extends TestCase
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
        $geo = new GeoBase();
        $result = $geo->get("91.77.237.161");

        $this->assertArrayHasKey('lat', $result);
        $this->assertArrayHasKey('lng', $result);
    }
}
