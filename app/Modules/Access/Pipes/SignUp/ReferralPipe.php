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
use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\User;
use App\Modules\Referral\Repositories\Referral;
use App\Modules\User\Repositories\UserReferral;

/**
 * Регистрация нового пользователя: запись реферала.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ReferralPipe implements Pipe
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
     * Репозитарий реферальных программ.
     *
     * @var \App\Modules\Referral\Repositories\Referral
     * @version 1.0
     * @since 1.0
     */
    private $_referral;

    /**
     * Репозитарий пользовательских рефералов.
     *
     * @var \App\Modules\User\Repositories\UserReferral
     * @version 1.0
     * @since 1.0
     */
    private $_userReferral;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\Referral\Repositories\Referral $referral Репозитарий реферальных программ.
     * @param \App\Modules\User\Repositories\UserReferral $userReferral Репозитарий пользовательских рефералов.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, Referral $referral, UserReferral $userReferral)
    {
        $this->_user = $user;
        $this->_referral = $referral;
        $this->_userReferral = $userReferral;
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
        if($content["uid"])
        {
            $referral = $this->_referral->get(null, true, [
                [
                    'property' => "type",
                    'value' => "user"
                ]
            ]);

            if($referral)
            {
                $this->_userReferral->create([
                    'referral_id' => $referral["id"],
                    'user_invited_id' => $content["id"],
                    'user_inviting_id' => $content["uid"]
                ]);

                if(!$this->_userReferral->hasError()) return $next($content);
                else
                {
                    $this->_user->destroy($content["id"]);

                    /**
                     * @var $entity \App\Models\Decorator
                     */
                    $entity = $content["entity"];
                    $entity->setErrors($this->_user->getErrors());

                    return false;
                }
            }
            else return $next($content);
        }
        else return $next($content);
    }
}
