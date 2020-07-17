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

use App\Modules\School\Models\School;

/**
 * Класс обработчик событий для модели школ.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SchoolListener
{
    /**
     * Обработчик события при удалении школы.
     *
     * @param \App\Modules\School\Models\School $school Модель для таблицы школ.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleting(School $school)
    {
        if($school->image_small_id) ImageStore::destroy($school->image_small_id["id"]);
        if($school->image_middle_id) ImageStore::destroy($school->image_middle_id["id"]);
        if($school->image_big_id) ImageStore::destroy($school->image_big_id["id"]);

        $school->deleteRelation($school->userSchools(), $school->isForceDeleting());
        $school->deleteRelation($school->roles(), $school->isForceDeleting());
        $school->deleteRelation($school->limits(), $school->isForceDeleting());

        return true;
    }
}
