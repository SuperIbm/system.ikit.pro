<?php
/**
 * Генераторы случайных данных.
 * Пакет содержит классы для классов генериторов случайных данных
 *
 * @package App.Models.Fakers
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Fakers;

use Faker\Provider\Base;

/**
 * Класс для создания слуайного номера телефона.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PhoneFaker extends Base
{
    /**
     * Метод для получения телефона
     *
     * @param int $code Код страны.
     *
     * @return string Вернет номер телефона.
     * @since 1.0
     * @version 1.0
     */
    public function phone(int $code = 1): string
    {
        return "+" . $code . "-" . rand(100, 999) . "-" . rand(100, 999) . "-" . rand(1000, 9999);
    }
}
