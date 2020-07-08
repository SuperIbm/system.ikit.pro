<?php
/**
 * Модуль Школ.
 * Этот модуль содержит все классы для работы школами.
 *
 * @package App\Modules\School
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\School\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Фасад класса школы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class School extends Facade
{
    /**
     * Получить зарегистрированное имя компонента.
     *
     * @return string
     * @version 1.0
     * @since 1.0
     */
    protected static function getFacadeAccessor()
    {
        return 'school';
    }
}
