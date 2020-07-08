<?php
/**
 * Модуль Школ.
 * Этот модуль содержит все классы для работы школами.
 *
 * @package App\Modules\School
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\School\Models;

use App\Modules\School\Repositories\School;

/**
 * Класс реализации текущей школы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Implement
{
    /**
     * Репозитарий школ.
     *
     * @var \App\Modules\School\Repositories\School
     * @version 1.0
     * @since 1.0
     */
    private $_school;

    /**
     * Данные текущей школы.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    private $_data = [];

    /**
     * Конструктор.
     *
     * @param \App\Modules\School\Repositories\School $school Репозитарий школ.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(School $school)
    {
        $this->_school = $school;
    }

    /**
     * Установить текущую школу по ID.
     *
     * @param int $id ID Школы.
     *
     * @return \App\Modules\School\Models\Implement|bool Вернет текущий объект.
     * @since 1.0
     * @version 1.0
     */
    public function setById(int $id)
    {
        $school = $this->_school->get($id, true);

        if($school)
        {
            $this->_data = $school;

            return $this;
        }
        else return false;
    }

    /**
     * Установить текущую школу по ее индексу.
     *
     * @param string $index Индекс школы.
     *
     * @return \App\Modules\School\Models\Implement|bool Вернет текущий объект.
     * @since 1.0
     * @version 1.0
     */
    public function setByIndex(string $index)
    {
        $school = $this->_school->get(null, true, [
            [
                'property' => 'index',
                'value' => $index
            ]
        ]);

        if($school)
        {
            $this->_data = $school;

            return $this;
        }
        else return false;
    }

    /**
     * Получить данные текущей школы.
     *
     * @return array Вернет массив текущей школы.
     * @since 1.0
     * @version 1.0
     */
    public function get()
    {
        return ($this->_data && count($this->_data)) ? $this->_data : null;
    }

    /**
     * Получить ID текушей школы.
     *
     * @return int Вернет ID школы.
     * @since 1.0
     * @version 1.0
     */
    public function getId()
    {
        return ($this->_data && count($this->_data)) ? $this->_data["id"] : null;
    }

    /**
     * Получить индекс текушей школы.
     *
     * @return string Вернет индекс школы.
     * @since 1.0
     * @version 1.0
     */
    public function getIndex()
    {
        return ($this->_data && count($this->_data)) ? $this->_data["index"] : null;
    }

    /**
     * Сбить текущую школу.
     *
     * @return \App\Modules\School\Models\School Текущая школа.
     * @since 1.0
     * @version 1.0
     */
    public function reset(): Implement
    {
        $this->_data = [];

        return $this;
    }
}
