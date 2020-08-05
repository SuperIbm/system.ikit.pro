<?php
/**
 * Модуль Разделы системы.
 * Этот модуль содержит все классы для работы с разделами системы.
 *
 * @package App\Modules\Section
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Section\Events\Listeners;

use App\Modules\Section\Models\Section;

/**
 * Класс обработчик событий для модели разделов системы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SectionListener
{
    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\Section\Models\Section $section Модель для таблицы разделов системы.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(Section $section): bool
    {
        $section->deleteRelation($section->planRoleSections(), $section->isForceDeleting());
        $section->deleteRelation($section->schoolRoleSections(), $section->isForceDeleting());

        return true;
    }
}
