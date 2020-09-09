<?php
/**
 * Тестирование ядра базовых классов.
 * Этот пакет содержит набор тестов для ядра баззовых классов.
 *
 * @package App.Tests.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Tests\Models\Geocoder;

use Tests\TestCase;
use App\Models\Geocoder\GeocoderGoogle;

/**
 * Тестирование: Класс драйвер геокодирования на основе сервиса Google.com.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeocoderGoogleTest extends TestCase
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
        $geocoder = new GeocoderGoogle();
        $result = $geocoder->get("680009", "Россия", "Хабаровск", null, "ул. Ким-Ю-Чена, 33");

        $this->assertArrayHasKey('latitude', $result);
        $this->assertArrayHasKey('longitude', $result);
    }
}
