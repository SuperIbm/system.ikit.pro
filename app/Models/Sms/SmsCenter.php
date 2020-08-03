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
use Storage;
use Config;

/**
 * Классы драйвер для отправик СМС сообщений с сайта с использованием СмсЦентр - www.smsc.ru.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SmsCenter extends Sms
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
        $msg = iconv("utf-8", "windows-1251", $message);
        $url = "http://smsc.ru/sys/send.php?login=" . Config::get("sms.center.login") . "&psw=" . Config::get("sms.center.password") . "&phones=" . $phone . "&mes=" . $msg . "&sender=" . $sender . "&fmt=3";

        $respose = Storage::url($url);
        $result = json_decode($respose, true);

        switch(isset($result["error_code"]))
        {
            case 1:
                $this->addError("noSend", "Ошибка в параметрах.", 1);
                break;
            case 2:
                $this->addError("noSend", "Неверный логин или пароль.", 2);
                break;
            case 3:
                $this->addError("noSend", "Недостаточно средств на счете Клиента.", 3);
                break;
            case 4:
                $this->addError("noSend", "IP-адрес временно заблокирован из-за частых ошибок в запросах.", 4);
                break;
            case 5:
                $this->addError("noSend", "Неверный формат даты.", 5);
                break;
            case 6:
                $this->addError("noSend", "Сообщение запрещено (по тексту или по имени отправителя).", 6);
                break;
            case 7:
                $this->addError("noSend", "Неверный формат номера телефона.", 7);
                break;
            case 8:
                $this->addError("noSend", "Сообщение на указанный номер не может быть доставлено.", 8);
                break;
            case 9:
                $this->addError("noSend", "Отправка более одного одинакового запроса на передачу SMS-сообщения либо более пяти одинаковых запросов на получение стоимости сообщения в течение минуты.", 9);
                break;
        }

        if(!isset($result["error_code"]))
        {
            $this->cleanError();
            return $result["id"];
        }
        else return false;
    }


    /**
     * Проверки статуса отправки сообщения.
     *
     * @param string $index Индекс отправленного сообщения.
     * @param string $phone Номер телефона.
     *
     * @return bool Вернет true, если сообщение было отправлено.
     * @since 1.0
     * @version 1.0
     * @see \App\Models\Contracts\Sms::check
     * @throws
     */
    public function check(string $index, string $phone): bool
    {
        $url = "http://smsc.ru/sys/status.php?login=" . Config::get("sms.center.login") . "&psw=" . Config::get("sms.center.password") . "&phone=" . $phone . "&id=" . $index . "&fmt=3";

        $respose = Storage::get($url);
        $result = json_decode($respose, true);

        if(isset($result["error_code"]))
        {
            $this->addError("noCheck", $result["error"], $result["error_code"]);
            return false;
        }
        else if(isset($result["err"]))
        {
            $this->addError("noSent", $result["err"]);
            return false;
        }
        else if(isset($result["status"]))
        {
            switch(@$result["status"])
            {
                case -3:
                    $this->addError("noSent", "Сообщение не найдено.", -3);
                    return false;
                case -1:
                    $this->addError("noSent", "Ожидает отправки.", -3);
                    return false;
                case 0:
                    $this->addError("noSent", "Передано оператору.", 0);
                    return false;
                case 3:
                    $this->addError("noSent", "Просрочено.", 3);
                    return false;
                case 20:
                    $this->addError("noSent", "Невозможно доставить.", 20);
                    return false;
                case 22:
                    $this->addError("noSent", "Неверный номер.", 22);
                    return false;
                case 23:
                    $this->addError("noSent", "Запрещено.", 23);
                    return false;
                case 24:
                    $this->addError("noSent", "Недостаточно средств.", 24);
                    return false;
                case 25:
                    $this->addError("noSent", "Недоступный номер.", 25);
                    return false;
                case 1:
                    $this->cleanError();
                    return true;
            }
        }

        return false;
    }
}
