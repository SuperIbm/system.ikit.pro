<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Pipes\Social;

use App\Models\Contracts\Pipe;
use Closure;
use Str;

/**
 * Регистрация нового пользователя через соцаильные сети: Получение данных для авторизованного пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DataPipe implements Pipe
{
    /**
     * Метод который будет вызван у pipeline.
     *
     * @param array $content Содержит массив свойств, которые можно передавать от pipe к pipe.
     * @param Closure $next Ссылка на следующий pipe.
     *
     * @return mixed Вернет значение полученное после выполнения следующего pipe.
     */
    public function handle(array $content, Closure $next)
    {
        if($content["create"] && !isset($content["user"]["password"]))
        {
            $content["user"]["password"] = bcrypt(Str::random(8));
            return $next($content);
        }
        else
        {
            $data = [
                "gate" => $content["gate"],
                "secret" => $content["client"]["secret"],
                "token" => $content["token"],
            ];

            return $data;
        }
    }
}
