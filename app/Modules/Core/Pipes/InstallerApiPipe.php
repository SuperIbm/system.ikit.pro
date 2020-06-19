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

use Artisan;
use App\Models\Contracts\Pipe;
use Closure;

/**
 * Запуск установки API аунтификации и создания окружения.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerApiPipe implements Pipe
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
        Artisan::call("passport:install");

        return $next($content);
    }
}
