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
use App\Modules\User\Decorators\UserUpdateDecorator;
use App\Modules\User\Pipes\Check\SchoolPipe;
use App\Modules\User\Pipes\Update\UpdatePipe;
use App\Modules\User\Pipes\Update\ImagePipe;
use App\Modules\User\Pipes\Update\AddressPipe;
use App\Modules\User\Pipes\Update\RolePipe;

/**
 * Создание пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserUpdateAction extends Action
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
        $decorator = app(UserUpdateDecorator::class);

        $data = $decorator->setActions([
            SchoolPipe::class,
            UpdatePipe::class,
            ImagePipe::class,
            AddressPipe::class,
            RolePipe::class
        ])->setParameters([
            "id" => $this->getParameter("id"),
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
