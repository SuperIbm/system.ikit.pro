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
use App\Modules\Access\Decorators\AccessSocialDecorator;
use App\Modules\Access\Pipes\Gate\GetPipe;
use App\Modules\Access\Pipes\SignIn\AuthPipe;
use App\Modules\Access\Pipes\SignUp\ReferralPipe;
use App\Modules\Access\Pipes\SignUp\VerificationPipe;
use App\Modules\Access\Pipes\SignUp\WalletPipe;
use App\Modules\Access\Pipes\Social\CheckPipe;
use App\Modules\Access\Pipes\Social\ClientPipe;
use App\Modules\Access\Pipes\Social\DataPipe;
use App\Modules\Access\Pipes\SignUp\CreatePipe;

/**
 * Регистрация нового пользователя через соцаильные сети.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSocialAction extends Action
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
        $decorator = app(AccessSocialDecorator::class);

        $data = $decorator->setActions([
            CheckPipe::class,
            ClientPipe::class,
            DataPipe::class,
            CreatePipe::class,
            ReferralPipe::class,
            WalletPipe::class,
            VerificationPipe::class,
            GetPipe::class,
            AuthPipe::class,
            DataPipe::class,
        ])->setParameters([
            "user" => [
                "login" => $this->getParameter("login"),
                "first_name" => $this->getParameter("first_name"),
                "second_name" => $this->getParameter("second_name"),
                "verified" => $this->getParameter("verified"),
            ],
            "id" => $this->getParameter("id"),
            "type" => $this->getParameter("type"),
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
