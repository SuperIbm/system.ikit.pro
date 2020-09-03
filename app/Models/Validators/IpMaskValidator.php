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
 * Классы для валидации маски IP.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class IpMaskValidator
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
    public function validate(?string $attribute, $value): bool
    {
        return preg_match('/^(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))$/', $value);
    }
}
