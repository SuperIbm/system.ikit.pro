<?php
/**
 * Валидирование.
 * Пакет содержит классы для расширения способов валидирования.
 *
 * @package App.Models.Validators
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Validators;

/**
 * Классы для валидации дробных чисел.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FloatValidator
{
    /**
     * Валидация.
     *
     * @param string $attribute Название атрибута.
     * @param mixed $value Значение для валидации.
     *
     * @return bool Вернет результат валидации.
     * @since 1.0
     * @version 1.0
     */
    public function validate(string $attribute, $value): bool
    {
        if(is_numeric($value))
        {
            $value = floatval($value);

            if(is_integer($value) || is_float($value)) return true;
        }

        return false;
    }
}
