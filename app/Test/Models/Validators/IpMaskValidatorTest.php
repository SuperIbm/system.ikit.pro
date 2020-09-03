<?php
/**
 * Тестирование ядра базовых классов.
 * Этот пакет содержит набор тестов для ядра баззовых классов.
 *
 * @package App.Test.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Test\Models\Validators;

use Tests\TestCase;
use App\Models\Validators\IpMaskValidator;

/**
 * Тестирование: Классы для валидации дробных чисел.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class IpMaskValidatorTest extends TestCase
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
        $validator = new IpMaskValidator();
        $result = $validator->validate(null, "128.0.0.*");

        $this->assertTrue($result);
    }
}
