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

use App\Modules\Plan\Models\PlanLimit;

/**
 * Класс обработчик событий для модели лимитов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class PlanLimitListener
{
    /**
     * Обработчик события при удалении лимитов.
     *
     * @param \App\Modules\Plan\Models\PlanLimit $planLimit Модель для таблицы лимитов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(PlanLimit $planLimit)
    {
        $planLimit->deleteRelation($planLimit->schoolLimits(), $planLimit->isForceDeleting());

        return true;
    }
}
