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

use Config;
use App\Models\Contracts\Pipe;
use Closure;
use App\Modules\User\Repositories\User;
use Illuminate\Encryption\Encrypter;

/**
 * Запуск установки конфигурации ключа для шифрования в системе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerAppKeyPipe implements Pipe
{
    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @since 1.0
     * @version 1.0
     */
    private $_user;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User Репозитарий пользователей.
     */
    public function __construct(User $User)
    {
        $this->_user = $User;
    }

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
        $key = 'base64:' . base64_encode(Encrypter::generateKey(Config::get('app.cipher')));
        $content["result"]["APP_KEY"] = $key;
        Config::set('app.key', $key);

        /**
         * @var $command \Illuminate\Console\Command
         */
        $command = $content["command"];

        $this->_user->update(1, [
            'login' => $command->ask('Enter your admin login', 'admin@admin.com'),
            'password' => bcrypt($command->ask('Enter your admin password', 'admin'))
        ]);

        return $next($content);
    }
}
