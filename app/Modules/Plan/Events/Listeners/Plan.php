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

use App\Modules\Plan\Models\Plan;

/**
 * Класс обработчик событий для модели тарифов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PlanListener
{
    /**
     * Обработчик события при удалении тарифов.
     *
     * @param \App\Modules\Plan\Models\Plan $plan Модель для таблицы тарифов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(Plan $plan)
    {
        $plan->deleteRelation($plan->roles(), $plan->isForceDeleting());

        return true;
    }
}
