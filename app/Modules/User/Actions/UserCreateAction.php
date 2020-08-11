<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\User\Actions;

use App\Models\Action;
use App\Modules\User\Decorators\UserCreateDecorator;
use App\Modules\User\Pipes\Create\CreatePipe;
use App\Modules\User\Pipes\Create\ImagePipe;
use App\Modules\User\Pipes\Create\SchoolPipe;
use App\Modules\User\Pipes\Create\AddressPipe;
use App\Modules\User\Pipes\Create\RolePipe;

/**
 * Создание пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserCreateAction extends Action
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
        $decorator = app(UserCreateDecorator::class);

        $data = $decorator->setActions([
            CreatePipe::class,
            ImagePipe::class,
            SchoolPipe::class,
            AddressPipe::class,
            RolePipe::class
        ])->setParameters([
            "user" => $this->getParameter("user"),
            "image" => $this->getParameter("image"),
            "school" => $this->getParameter("school"),
            "address" => $this->getParameter("address"),
            "roles" => $this->getParameter("roles")
        ])->run();

        if(!$decorator->hasError()) return $data;
        else
        {
            $this->setErrors($decorator->getErrors());
            return false;
        }
    }
}
