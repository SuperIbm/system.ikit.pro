<?php
/**
 * Каналы.
 * Этот пакет содержит каналы для быстрой отправки сообщений.
 *
 * @package App.Models.Channels
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Channels;

use Illuminate\Notifications\Notification;
use Sms as SmsFacade;

/**
 * Канал отправки SMS сообщений.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Sms
{
    /**
     * Отправка сообщения.
     *
     * @param mixed $notifiable
     * @param \Illuminate\Notifications\Notification $notification
     *
     * @return \App\Models\Facades\Sms;
     * @since 1.0
     * @version 1.0
     */
    public function send($notifiable, Notification $notification)
    {
        $message = $notification->toSms($notifiable);

        return SmsFacade::send
        (
            $notifiable->routeNotificationForPhone(),
            $message->message,
            $message->sender,
            $message->translit
        );
    }
}
