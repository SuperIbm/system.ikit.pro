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
use App\Models\Validators\FloatValidator;

/**
 * Тестирование: Классы для валидации дробных чисел.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FloatValidatorTest extends TestCase
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
        $validator = new FloatValidator();
        $result = $validator->validate(null, 500.2);

        $this->assertTrue($result);
    }
}
