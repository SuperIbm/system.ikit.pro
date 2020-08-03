<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Pipes\Update;

use Closure;
use Geocoder;
use App\Models\Contracts\Pipe;
use App\Modules\User\Repositories\UserAddress;

/**
 * Изменение информации о пользователе: обновляем данные о пользователе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AddressPipe implements Pipe
{
    /**
     * Репозитарий адреса пользователя.
     *
     * @var \App\Modules\User\Repositories\UserAddress
     * @version 1.0
     * @since 1.0
     */
    private $_userAddress;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\UserAddress $userAddress Репозитарий адреса пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(UserAddress $userAddress)
    {
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
        $user = $content["user"];

        if($user)
        {
            $address = $content["data"];

            if(!isset($address["latitude"]) || !isset($address["longitude"]))
            {
                $coordinate = Geocoder::get(@$address["postal_code"], @$address["country"], @$address["city"], @$address["region"], @$address["street_address"]);

                if(!Geocoder::hasError())
                {
                    $address["latitude"] = $coordinate["latitude"];
                    $address["longitude"] = $coordinate["longitude"];
                }
            }

            $filters = [
                [
                    "table" => "user_addresses",
                    "property" => "user_id",
                    "operator" => "=",
                    "value" => $user["id"],
                    "logic" => "and"
                ]
            ];

            $record = $this->_userAddress->get(null, $filters);

            if($record) $this->_userAddress->update($record["id"], $address);
            else $this->_userAddress->create($address);

            if(!$this->_userAddress->hasError()) return $next($content);
            else
            {
                /**
                 * @var $decorator \App\Models\Decorator
                 */
                $decorator = $content["decorator"];
                $decorator->setErrors($this->_userAddress->getErrors());

                return false;
            }
        }
        else
        {
            /**
             * @var $decorator \App\Models\Decorator
             */
            $decorator = $content["decorator"];
            $decorator->addError("user", trans('access::pipes.update.userPipe.not_exist_user'));

            return false;
        }
    }
}
