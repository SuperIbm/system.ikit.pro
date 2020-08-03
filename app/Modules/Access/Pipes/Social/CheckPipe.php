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
use Kreait\Firebase\Auth;
use Closure;
use App\Models\Error;

/**
 * Авторизация через социальнеы сети: проверка входа через соц. сеть.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CheckPipe implements Pipe
{
    use Error;

    /**
     * Класс для работы с Firebase.
     *
     * @var \Kreait\Firebase\Auth
     * @version 1.0
     * @since 1.0
     */
    private Auth $_auth;

    /**
     * Конструктор.
     *
     * @param \Kreait\Firebase\Auth $auth Класс для работы с Firebase.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Auth $auth)
    {
        $this->_auth = $auth;
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
        if($this->_check($content["id"])) return $next($content);
        else
        {
            /**
             * @var $decorator \App\Models\Decorator
             */
            $decorator = $content["decorator"];
            $decorator->setErrors($this->getErrors());

            return false;
        }
    }

    /**
     * Проверка возможности подобной авторизации.
     *
     * @param string $id Индификаионный номер авторизации.
     *
     * @return mixed Вернет успешность проверки.
     * @since 1.0
     * @version 1.0
     */
    private function _check($id): bool
    {
        try
        {
            $this->_auth->verifyIdToken($id);

            return true;
        }
        catch(\Exception $err)
        {
            $this->addError("access", $err->getMessage());

            return false;
        }
    }
}
