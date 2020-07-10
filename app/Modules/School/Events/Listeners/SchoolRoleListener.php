<?php
/**
 * Модуль Школ.
 * Этот модуль содержит все классы для работы школами.
 *
 * @package App\Modules\School
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\School\Events\Listeners;

use App\Modules\School\Models\SchoolRole;

/**
 * Класс обработчик событий для модели ролей школы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolRoleListener
{
    /**
     * Обработчик события при удалении роли школы.
     *
     * @param \App\Modules\School\Models\SchoolRole $schoolRole Модель для таблицы ролей школы.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(SchoolRole $schoolRole)
    {
        $schoolRole->deleteRelation($schoolRole->sections(), $schoolRole->isForceDeleting());

        return true;
    }
}
