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
 * Класс для вадидации рейнджа дробного числа.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class FloatBetweenValidator
{
    /**
     * Валидация.
     *
     * @param string $attribute Название атрибута.
     * @param mixed $value Значение для валидации.
     * @param array $parameters Параметры.
     *
     * @return bool Вернет результат валидации.
     * @since 1.0
     * @version 1.0
     */
    public function validate($attribute, $value, array $parameters): bool
    {
        if(is_numeric($value))
        {
            $value = floatval($value);

            if(is_integer($value) || is_float($value))
            {
                $length = strlen((string) $value);

                return $length >= $parameters[0] && $length <= $parameters[1];
            };
        }

        return false;
    }
}
