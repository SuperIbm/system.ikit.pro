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

use App\Modules\User\Repositories\UserAuth;
use App\Models\Contracts\Pipe;
use Closure;
use Device;
use Request;
use Geo;

/**
 * Авторизация пользователя: Запись об авторизации пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AuthPipe implements Pipe
{
    /**
     * Репозитарий авторизаций пользователя.
     *
     * @var \App\Modules\User\Repositories\UserAuth
     * @version 1.0
     * @since 1.0
     */
    private $_userAuth;

    /**
     * Конструктор.
     *
     * @param \App\Modules\User\Repositories\UserAuth $userAuth Репозитарий авторизаций пользователя.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(UserAuth $userAuth)
    {
        $this->_userAuth = $userAuth;
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
        $location = Geo::get();

        $this->_userAuth->create([
            'user_id' => $content["gate"]["user"]["id"],
            'os' => Device::system()["os"],
            'device' => Device::system()["device"],
            'browser' => Device::browser(),
            'agent' => Device::getAgent(),
            'ip' => Request::ip(),
            'latitude' => isset($location["lat"]) ? $location["lat"] : null,
            'longitude' => isset($location["lng"]) ? $location["lng"] : null,
        ]);

        return $next($content);
    }
}
