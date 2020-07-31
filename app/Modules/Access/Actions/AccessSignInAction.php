<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Actions;

use App\Models\Action;
use App\Modules\Access\Decorators\AccessSignInDecorator;

use App\Modules\Access\Pipes\SignIn\LoginPipe;
use App\Modules\Access\Pipes\SignIn\GatePipe;
use App\Modules\Access\Pipes\SignIn\AuthPipe;
use App\Modules\Access\Pipes\SignIn\DataPipe;

/**
 * Регистрация нового пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSignInAction extends Action
{
    /**
     * Метод запуска логики.
     *
     * @return mixed Вернет результаты исполнения.
     * @since 1.0
     * @version 1.0
     */
    public function run()
    {
        $decorator = app(AccessSignInDecorator::class);

        $data = $decorator->setActions([
            LoginPipe::class,
            GatePipe::class,
            AuthPipe::class,
            DataPipe::class
        ])->setParameters([
            "login" => $this->getParameter("login"),
            "password" => $this->getParameter("password"),
            "remember" => $this->getParameter("remember")
        ])->run();

        if(!$decorator->hasError()) return $data;
        else
        {
            $this->setErrors($decorator->getErrors());
            return false;
        }
    }
}
