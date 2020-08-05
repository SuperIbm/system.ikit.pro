<?php
/**
 * Модуль Тарифа.
 * Этот модуль содержит все классы для работы тарифами.
 *
 * @package App\Modules\Plan
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Plan\Events\Listeners;

use App\Modules\Plan\Models\PlanRole;

/**
 * Класс обработчик событий для модели тарифов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PlanRoleListener
{
    /**
     * Обработчик события при удалении тарифов.
     *
     * @param \App\Modules\Plan\Models\PlanRole $planRole Модель для таблицы тарифов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(PlanRole $planRole): bool
    {
        $planRole->deleteRelation($planRole->userRole(), $planRole->isForceDeleting());
        $planRole->deleteRelation($planRole->sections(), $planRole->isForceDeleting());

        return true;
    }
}
