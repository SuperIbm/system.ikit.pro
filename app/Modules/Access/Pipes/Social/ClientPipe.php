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
use App\Modules\Access\Actions\AccessApiClientAction;
use App\Modules\Access\Actions\AccessApiTokenAction;
use App\Modules\Access\Actions\AccessGateAction;
use Closure;

/**
 * Регистрация нового пользователя через соцаильные сети: получение клиента.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ClientPipe implements Pipe
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
        $action = app(AccessApiClientAction::class);

        $client = $action->setParameters([
            "login" => $content["user"]["login"],
            "force" => true
        ])->run();

        if($client)
        {
            $action = app(AccessApiTokenAction::class);

            $token = $action->setParameters([
                "secret" => $client["secret"]
            ])->run();

            $gate = app(AccessGateAction::class)->setParameters([
                "id" => $client["user"]["id"]
            ])->run();

            $content["create"] = true;
            $content["gate"] = $gate;
            $content["client"] = $client;
            $content["token"] = $token;

            return true;
        }
        else
        {
            $content["create"] = true;

            return $next($content);
        }
    }
}
