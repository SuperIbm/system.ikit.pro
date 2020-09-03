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
use App\Models\Validators\PhoneValidator;

/**
 * Тестирование: Классы для валидации дробных чисел.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PhoneValidatorTest extends TestCase
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
        $validator = new PhoneValidator();
        $result = $validator->validate(null, "+1-999-099-9000", ['1']);

        $this->assertTrue($result);
    }
}
