<?php
/**
 * Модуль Рефералов.
 * Этот модуль содержит все классы для работы с рефералами.
 *
 * @package App\Modules\Referral
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Referral\Events\Listeners;

use App\Modules\Referral\Models\Referral;

/**
 * Класс обработчик событий для модели рефералов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ReferralListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\Referral\Models\Referral $referral Модель для таблицы рефералов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(Referral $referral)
    {
        $referral->deleteRelation($referral->users(), $referral->isForceDeleting());

        return true;
    }
}
