<?php
/**
 * Отправка SMS.
 * Пакет содержит классы для отправки SMS с сайта.
 *
 * @package App.Models.Sms
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Sms;

use Config;
use Illuminate\Support\Manager;

/**
 * Класс системы отправки СМС сообщений.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SmsManager extends Manager
{
    /**
     * @see \Illuminate\Support\Manager::getDefaultDriver
     */
    public function getDefaultDriver()
    {
        return Config::get('sms.driver');
    }
}
