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
use App\Modules\Access\Decorators\AccessSignUpDecorator;
use App\Modules\Access\Pipes\SignUp\CreatePipe;
use App\Modules\Access\Pipes\SignUp\ReferralPipe;
use App\Modules\Access\Pipes\SignUp\WalletPipe;
use App\Modules\Access\Pipes\SignUp\VerificationPipe;
use App\Modules\Access\Pipes\Gate\GetPipe;

/**
 * Регистрация нового пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSignUpAction extends Action
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
        $decorator = app(AccessSignUpDecorator::class);

        $data = $decorator->setActions([
            CreatePipe::class,
            ReferralPipe::class,
            WalletPipe::class,
            VerificationPipe::class,
            GetPipe::class
        ])->setParameters([
            "user" => [
                "login" => $this->getParameter("login"),
                "password" => $this->getParameter("password"),
                "first_name" => $this->getParameter("first_name"),
                "second_name" => $this->getParameter("second_name"),
                "telephone" => $this->getParameter("telephone"),
                "verified" => $this->getParameter("verified"),
            ],
            "uid" => $this->getParameter("uid")
        ])->run();

        if(!$decorator->hasError()) return $data;
        else
        {
            $this->setErrors($decorator->getErrors());
            return false;
        }
    }
}
