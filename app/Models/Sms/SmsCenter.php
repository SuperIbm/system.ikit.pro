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
                $this->addError("noSend", trans('modules.sms.smsCenter.params'));
                break;
            case 2:
                $this->addError("noSend", trans('modules.sms.smsCenter.access'));
                break;
            case 3:
                $this->addError("noSend", trans('modules.sms.smsCenter.balance'));
                break;
            case 4:
                $this->addError("noSend", trans('modules.sms.smsCenter.block'));
                break;
            case 5:
                $this->addError("noSend", trans('modules.sms.smsCenter.format'));
                break;
            case 6:
                $this->addError("noSend", trans('modules.sms.smsCenter.prohibited'));
                break;
            case 7:
                $this->addError("noSend", trans('modules.sms.smsCenter.invalid'));
                break;
            case 8:
                $this->addError("noSend", trans('modules.sms.smsCenter.unreached'));
                break;
            case 9:
                $this->addError("noSend", trans('modules.sms.smsCenter.limit'));
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
     * @throws
     * @version 1.0
     * @see \App\Models\Contracts\Sms::check
     * @since 1.0
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
                    $this->addError("noSent", trans('modules.sms.smsCenter.not_exist'));
                    return false;
                case -1:
                    $this->addError("noSent", trans('modules.sms.smsCenter.processing'));
                    return false;
                case 0:
                    $this->addError("noSent", trans('modules.sms.smsCenter.transmitted'));
                    return false;
                case 3:
                    $this->addError("noSent", trans('modules.sms.smsCenter.expired'));
                    return false;
                case 20:
                    $this->addError("noSent", trans('modules.sms.smsCenter.undelivered'));
                    return false;
                case 22:
                    $this->addError("noSent", trans('modules.sms.smsCenter.invalid'));
                    return false;
                case 23:
                    $this->addError("noSent", trans('modules.sms.smsCenter.prohibited'));
                    return false;
                case 24:
                    $this->addError("noSent", trans('modules.sms.smsCenter.balance'));
                    return false;
                case 25:
                    $this->addError("noSent", trans('modules.sms.smsCenter.unavailable'));
                    return false;
                case 1:
                    $this->cleanError();
                    return true;
            }
        }

        return false;
    }
}
