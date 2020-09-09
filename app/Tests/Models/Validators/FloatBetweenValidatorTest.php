<?php
/**
 * Тестирование ядра базовых классов.
 * Этот пакет содержит набор тестов для ядра баззовых классов.
 *
 * @package App.Tests.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Tests\Models\Validators;

use Tests\TestCase;
use App\Models\Validators\FloatBetweenValidator;

/**
 * Тестирование: Класс для вадидации рейнджа дробного числа.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FloatBetweenValidatorTest extends TestCase
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
        $validator = new FloatBetweenValidator();
        $result = $validator->validate(null, 500.2, [2, 6]);

        $this->assertTrue($result);
    }
}
