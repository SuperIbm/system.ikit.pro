<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\User\Pipes\Update;

use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\User;
use App\Modules\User\Repositories\UserAddress;
use Closure;

/**
 * Обновление пользователя: добавление адреса пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AddressPipe implements Pipe
{
    /**
     * Репозитарий пользователей.
     *
     * @var \App\Modules\User\Repositories\User
     * @version 1.0
     * @since 1.0
     */
    private User $_user;

    /**
     * Репозитарий адреса пользователя.
     *
     * @var \App\Modules\User\Repositories\UserAddress
     * @version 1.0
     * @since 1.0
     */
    private UserAddress $_userAddress;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\User $user Репозитарий пользователей.
     * @param \App\Modules\User\Repositories\UserAddress $userAddress Репозитарий адреса пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(User $user, UserAddress $userAddress)
    {
        $this->_user = $user;
        $this->_userAddress = $userAddress;
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
        if($content["address"])
        {
            $address = [
                'user_id' => $content["id"],
                'postal_code' => $content["address"]["postal_code"],
                'country' => $content["address"]["country"],
                'region' => $content["address"]["region"],
                'city' => $content["address"]["city"],
                'street_address' => $content["address"]["street_address"],
                'latitude' => $content["address"]["latitude"],
                'longitude' => $content["address"]["longitude"],
            ];

            $this->_userAddress->update($content["id"], $address);

            if(!$this->_userAddress->hasError()) return $next($content);
            else
            {
                /**
                 * @var $decorator \App\Models\Decorator
                 */
                $decorator = $content["decorator"];
                $decorator->setErrors($this->_userAddress->getErrors());

                $this->_user->destroy($content["id"]);

                return false;
            }
        }
        else return $next($content);
    }
}
