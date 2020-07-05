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
use App\Modules\Access\Tasks\AccessSiteCheckCodeResetPasswordTask;

/**
 * Проверка верности кода восстановления пароля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessSiteCheckResetPasswordAction extends Action
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
        $accessSiteCheckCodeResetPasswordTask = app(AccessSiteCheckCodeResetPasswordTask::class);

        $status = $accessSiteCheckCodeResetPasswordTask->setParameters([
            "id" => $this->getParameter("id"),
            "code" => $this->getParameter("code")
        ])->run();

        if($status) return true;
        else
        {
            $this->setErrors($accessSiteCheckCodeResetPasswordTask->getErrors());

            return false;
        }
    }
}
