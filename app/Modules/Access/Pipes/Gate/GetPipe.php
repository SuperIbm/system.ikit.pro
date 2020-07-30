<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Order\Pipes\Gate;

use App\Models\Contracts\Pipe;
use App\Modules\Access\Actions\AccessApiClientAction;
use App\Modules\Access\Actions\AccessApiTokenAction;
use App\Modules\Access\Actions\AccessGateAction;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserVerification;
use Closure;

/**
 * Данные о доступе пользователя: получение.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GetPipe implements Pipe
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
            "id" => $content["id"]
        ])->run();

        if($gate)
        {
            $action = app(AccessApiClientAction::class);

            $client = $action->setParameters([
                "login" => $gate["user"]["login"],
                "force" => true
            ])->run();

            if($client)
            {
                $action = app(AccessApiTokenAction::class);

                $token = $action->setParameters([
                    "secret" => $client["secret"]
                ])->run();

                if($token)
                {
                    $content["gate"] = $gate;
                    $content["client"] = $client;
                    $content["token"] = $token;

                    return $next($content);
                }
                else
                {
                    /**
                     * @var $entity \App\Models\Decorator
                     */
                    $entity = $content["entity"];
                    $entity->setErrors($action->getErrors());

                    return false;
                }
            }
            else
            {
                /**
                 * @var $entity \App\Models\Decorator
                 */
                $entity = $content["entity"];
                $entity->setErrors($action->getErrors());

                return false;
            }
        }
        else
        {
            /**
             * @var $entity \App\Models\Decorator
             */
            $entity = $content["entity"];
            $entity->setErrors($action->getErrors());

            return false;
        }
    }
}
