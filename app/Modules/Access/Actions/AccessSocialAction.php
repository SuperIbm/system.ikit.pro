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
use App\Modules\Access\Pipes\Social\CheckPipe;

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

        ])->setParameters([
            "user" => [
                "id" => $this->getParameter("id"),
                "type" => $this->getParameter("type"),
                "login" => $this->getParameter("login"),
                "parameters" => $this->getParameter("parameters"),
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
