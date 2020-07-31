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
use App\Modules\Access\Actions\AccessApiClientAction;
use App\Modules\Access\Actions\AccessApiTokenAction;
use App\Modules\User\Repositories\User;
use Closure;

/**
 * Авторизация пользователя: производим авторизацию и генерацию ключей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LoginPipe implements Pipe
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
            "login" => $content["login"],
            "password" => $content["password"]
        ])->run();

        if($client)
        {
            $action = app(AccessApiTokenAction::class);

            $token = $action->setParameters([
                "secret" => $client["secret"]
            ])->run();

            if($token)
            {
                $content["client"] = $client;
                $content["token"] = $token;

                return $next($content);
            }
            else
            {
                /**
                 * @var $decorator \App\Models\Decorator
                 */
                $decorator = $content["decorator"];
                $decorator->setErrors($action->getErrors());

                return false;
            }
        }
        else
        {
            /**
             * @var $decorator \App\Models\Decorator
             */
            $decorator = $content["decorator"];
            $decorator->setErrors($action->getErrors());

            return false;
        }
    }
}
