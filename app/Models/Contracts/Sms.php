<?php
/**
 * Контракты.
 * Этот пакет содержит контракты ядра системы.
 *
 * @package App.Models.Contracts
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Contracts;

use App\Models\Error;

/**
 * Абстрактный класс позволяющий проектировать собственные классы для отправик СМС сообщений с сайта.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Sms
{
    use Error;

    /**
     * Абстрактный метод отправки СМС сообщения.
     *
     * @param string $phone Номер телефона.
     * @param string $message Сообщение для отправки.
     * @param string $sender Отправитель.
     * @param bool $isTranslit Если указать true, то нужно транслетировать сообщение в латиницу.
     *
     * @return string Вернет индификатор сообщения, если сообщение было отправлено. Либо вернет false, если сообщение не было отправлено.
     * @since 1.0
     * @version 1.0
     */
    abstract public function send(string $phone, string $message, string $sender = null, bool $isTranslit = false);

    /**
     * Абстрактный метод проверки статуса отправки сообщения.
     *
     * @param string $index Индекс отправленного сообщения.
     * @param string $phone Номер телефона.
     *
     * @return bool Вернет true, если сообщение было отправлено.
     * @since 1.0
     * @version 1.0
     */
    abstract public function check(string $index, string $phone): bool;
}
