<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Emails;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Config;

/**
 * Класс для отправки верификации.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Verification extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Массив данных сообщения.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    private array $_data;

    /**
     * Конструктор.
     *
     * @param array $data Массив данных сообщения.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(array $data)
    {
        $this->_data = $data;
        $this->_data["site"] = Config::get("app.url");
    }

    /**
     * Построитель сообщения.
     *
     * @return \Illuminate\Mail\Mailable Верент объект письма.
     * @since 1.0
     * @version 1.0
     */
    public function build()
    {
        return $this->subject(trans('access::emails.verification.title'))->view("access::verification", $this->_data);
    }
}
