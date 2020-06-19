<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 *
 * @package App\Modules\Core
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Core\Pipes;

use Exception;
use Config;
use Mail;
use \Illuminate\Mail\Message;
use App\Models\Contracts\Pipe;
use Closure;

/**
 * Запуск установки конфигурации для почтовых отправлений.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerMailPipe implements Pipe
{
    /**
     * Метод который будет вызван у pipeline.
     *
     * @param array $content Содержит массив свойсв, которые можно передавать от pipe к pipe.
     * @param Closure $next Ссылка на следующий pipe.
     *
     * @return mixed Вернет значение полученное после выполнения следующего pipe.
     */
    public function handle($content, Closure $next)
    {
        $connected = false;

        $data = [
            'MAIL_DRIVER' => 'log',
            'MAIL_HOST' => '',
            'MAIL_PORT' => '',
            'MAIL_USERNAME' => '',
            'MAIL_PASSWORD' => '',
            'MAIL_ENCRYPTION' => '',
            'MAIL_FROM_ADDRESS' => '',
            'MAIL_FROM_NAME' => '',
            'MAIL_TO_ADDRESS' => ''
        ];

        /**
         * @var $command \Illuminate\Console\Command
         */
        $command = $content["command"];

        if($command->confirm('Would you like setting mail system? [Y|N]', false))
        {
            while(!$connected)
            {
                $data['MAIL_DRIVER'] = $command->choice('Select mail driver', [
                    'log',
                    'smtp',
                    'mail',
                    'sendmail',
                    'mailgun',
                    'mandrill',
                    'ses',
                    'sparkpost'
                ], 0);

                $data['MAIL_ENCRYPTION'] = $command->ask('Enter a encryption', 'tls');
                $data['MAIL_FROM_ADDRESS'] = $this->_borrow('Enter a from address', $command);
                $data['MAIL_FROM_NAME'] = $this->_borrow('Enter a from name', $command);
                $data['MAIL_TO_ADDRESS'] = $this->_borrow('Enter an email by default', $command);

                if($command->confirm('Would you like setting an authentication for your mail server? [Y|N]', false))
                {
                    $data['MAIL_HOST'] = $this->_borrow('Enter a host for your mail server', $command);
                    $data['MAIL_PORT'] = $this->_borrow('Enter a port for your mail server', $command);
                    $data['MAIL_USERNAME'] = $this->_borrow('Enter an user of name for your mail server', $command);
                    $data['MAIL_PASSWORD'] = $this->_borrow('Enter a password for your mail server', $command);
                }

                Config::set('mail.driver', $data['MAIL_DRIVER']);
                Config::set('mail.encryption', $data['MAIL_ENCRYPTION']);
                Config::set('mail.from.address', $data['MAIL_FROM_ADDRESS']);
                Config::set('mail.from.name', $data['MAIL_FROM_NAME']);
                Config::set('mail.to', $data['MAIL_TO_ADDRESS']);

                Config::set('mail.host', $data['MAIL_HOST']);
                Config::set('mail.port', $data['MAIL_PORT']);
                Config::set('mail.username', $data['MAIL_USERNAME']);
                Config::set('mail.password', $data['MAIL_USERNAME']);

                if($command->confirm('Would you like to check your mail server [Y|N]', false))
                {
                    try
                    {
                        Mail::raw("It's testing...", function(Message $message) use ($data)
                        {
                            $message->from($data["MAIL_FROM_ADDRESS"]);
                            $message->sender($data["MAIL_FROM_NAME"]);
                            $message->to($data["MAIL_TO_ADDRESS"]);
                            $message->subject("Hello. It's just testing...");
                        });

                        $connected = true;
                    }
                    catch(Exception $Exeption)
                    {
                        $command->error("Please ensure your mail server credentials are valid.");
                    }
                }
                else $connected = true;
            }
        }

        $content["result"] = array_merge($content["result"], $data);
        return $next($content);
    }


    /**
     * Запрос данных, но без обязательного указания.
     *
     * @param string $ask Вопрос.
     * @param \Illuminate\Console\Command $command Объкт коммандной строки.
     *
     * @return string Вернет результат запроса.
     * @since 1.0
     * @version 1.0
     */
    private function _borrow($ask, $command)
    {
        $answer = $command->ask($ask, '');

        if($answer == '') $answer = null;

        return $answer;
    }
}
