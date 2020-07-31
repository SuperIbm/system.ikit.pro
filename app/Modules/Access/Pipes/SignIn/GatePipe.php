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
use App\Modules\Access\Actions\AccessGateAction;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserVerification;
use Closure;

/**
 * Авторизация пользователя: Получение данных о пользовател.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GatePipe implements Pipe
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
        $action = app(AccessGateAction::class);

        $gate = $action->setParameters([
            "id" => $content["client"]["user"]["id"]
        ])->run();

        if($gate)
        {
            $content["gate"] = $gate;

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
}
