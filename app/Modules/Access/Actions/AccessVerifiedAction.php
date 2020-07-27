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
use App\Modules\Access\Decorators\AccessVerifiedDecorator;
use App\Modules\Order\Pipes\Verified\CheckPipe;
use App\Modules\Order\Pipes\Gate\GetPipe;

/**
 * Верификация пользователя.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessVerifiedAction extends Action
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
        $decorators = app(AccessVerifiedDecorator::class);

        $data = $decorators->setActions([
            CheckPipe::class,
            GetPipe::class
        ])->setParameters([
            "id" => $this->getParameter("id"),
            "code" => $this->getParameter("code"),
        ])->run();

        if(!$decorators->hasError()) return $data;
        else
        {
            $this->setErrors($decorators->getErrors());
            return false;
        }
    }
}
