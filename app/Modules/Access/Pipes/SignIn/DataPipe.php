<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Pipes\SignIn;

use App\Models\Contracts\Pipe;
use Closure;

/**
 * Авторизация пользователя: Получение данных для авторизованного пользователя.
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
        $data = [
            "gate" => $content["gate"]
        ];

        if($content["gate"]["user"]["two_factor"]) return $next($data);
        else
        {
            $data["secret"] = $content["client"]["secret"];
            $data["token"] = $content["token"];

            return $next($data);
        }
    }
}
