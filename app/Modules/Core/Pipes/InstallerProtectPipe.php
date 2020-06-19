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

/**
 * Запуск проверки была ли уже установлена система или нет.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerProtectPipe implements Pipe
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
        if(Config::get('app.installed') == true)
        {
            /**
             * @var $command \Illuminate\Console\Command
             */
            $command = $content["command"];
            $command->error('System has already been installed. You can already log into your administration.');

            return false;
        }
        else
        {
            $content["result"]['APP_INSTALLED'] = true;
        }

        return $next($content);
    }
}
