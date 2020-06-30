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

use App\Models\Contracts\Sms;
use Config;
use Nexmo\Client\Credentials\Basic;
use Nexmo\Client;
use \Exception;
use Log;

/**
 * Классы драйвер для отправик СМС сообщений с сайта с использованием Nexmo.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SmsNexmo extends Sms
{
    /**
     * Отправка СМС сообщения.
     *
     * @param string $phone Номер телефона.
     * @param string $message Сообщение для отправки.
     * @param string $sender Отправитель.
     * @param bool $isTranslit Если указать true, то нужно транслетировать сообщение в латиницу.
     *
     * @return string Вернет индификатор сообщения, если сообщение было отправлено. Либо вернет false, если сообщение не было отправлено.
     * @since 1.0
     * @version 1.0
     * @see \App\Models\Contracts\Sms::send
     */
    public function send(string $phone, string $message, string $sender, bool $isTranslit = false)
    {
        $basic = new Basic(Config::get("sms.nexmo.key"), Config::get("sms.nexmo.secret"));
        $client = new Client($basic);

        $phone = str_replace(["+", "-", ""], "", $phone);
        $sender = str_replace(["+", "-", ""], "", $sender);

        try
        {
            $client->message()->send([
                'to' => $phone,
                'from' => $sender,
                'text' => $message
            ]);
        }
        catch(Exception $err)
        {
            Log::error($err->getMessage(), [
                'module' => "SMS",
                'to' => $phone,
                'sender' => $sender,
                'message' => $message
            ]);

            $this->addError("send", $err->getMessage());
        }

        return true;
    }

    /**
     * Метод проверки статуса отправки сообщения.
     *
     * @param string $index Индекс отправленного сообщения.
     * @param string $phone Номер телефона.
     *
     * @return bool Вернет true, если сообщение было отправлено.
     * @since 1.0
     * @version 1.0
     */
    public function check(string $index, string $phone): bool
    {
        return true;
    }
}
