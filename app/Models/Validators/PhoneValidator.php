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
 * Классы для валидации телефона.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PhoneValidator
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
    public function validate(string $attribute, $value, array $parameters): bool
    {
        return preg_match('/\+'.$parameters[0].'( )?(\(|-)\d{3,3}\)?(-| )\d{3,3}-\d{4,4}/', $value);
    }
}
