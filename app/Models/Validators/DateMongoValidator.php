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

use MongoDB\BSON\UTCDateTime;

/**
 * Классы для валидации даты в базе данных MongoDB.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DateMongoValidator
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
        if($value instanceof UTCDateTime) return true;
        else return false;
    }
}
