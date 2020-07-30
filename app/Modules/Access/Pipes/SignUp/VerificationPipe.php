<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Order\Pipes\SignUp;

use Closure;
use Hash;
use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserVerification;
use App\Modules\Access\Actions\AccessSendEmailVerificationCodeAction;
use Carbon\Carbon;

/**
 * Регистрация нового пользователя: создания кода на верификации и его отправка пользователю.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class VerificationPipe implements Pipe
{
    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private $_user;

    /**
     * Репозитарий верификации пользователя.
     *
     * @var \App\Modules\User\Repositories\UserVerification
     * @version 1.0
     * @since 1.0
     */
    private $_userVerification;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserVerification $userVerification Репозитарий верификации пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserVerification $userVerification)
    {
        $this->_user = $user;
        $this->_userVerification = $userVerification;
    }

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
        $data["code"] = $content["id"] . Hash::make(intval(Carbon::now()->format("U")) + rand(1000000, 100000000));

        $this->_userVerification->create([
            "user_id" => $content["id"],
            "code" => $data["code"],
            "status" => $data["verified"]
        ]);

        if(!$this->_userVerification->hasError())
        {
            $action = app(AccessSendEmailVerificationCodeAction::class);

            if(!$data["verified"])
            {
                $result = $action->setParameters([
                    "id" => $content["id"]
                ])->run();
            }
            else $result = true;

            if($result) return $next($content);
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

            $this->_user->destroy($content["id"]);
            $entity->setErrors($this->_userVerification->getErrors());

            return false;
        }
    }
}
