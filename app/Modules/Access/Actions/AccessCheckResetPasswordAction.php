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

/**
 * Проверка верности кода восстановления пароля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessCheckResetPasswordAction extends Action
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
        $action = app(AccessCheckCodeResetPasswordAction::class);

        $status = $action->setParameters([
            "id" => $this->getParameter("id"),
            "code" => $this->getParameter("code")
        ])->run();

        if($status) return true;
        else
        {
            $this->setErrors($action->getErrors());

            return false;
        }
    }
}
