<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 *
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Models;


/**
 * Трейт для добавления возможности работать с параметрами.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait Parameter
{
    /**
     * Параметры.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    private $_parameters = [];

    /**
     * Добавление параметра.
     *
     * @param string $index Индекс параметра.
     * @param mixed $value Значение параметра.
     *
     * @return \App\Models\Parameter Вернет текущую модель.
     * @since 1.0
     * @version 1.0
     */
    public function addParameter(string $index, $value)
    {
        $this->_parameters[$index] = $value;

        return $this;
    }

    /**
     * Добавление всех параметров.
     *
     * @param mixed $values Массив параметров.
     *
     * @return \App\Models\Parameter Вернет текущую модель.
     * @since 1.0
     * @version 1.0
     */
    public function setParameters(array $values)
    {
        $this->_parameters = $values;

        return $this;
    }

    /**
     * Удаление всех параметров.
     *
     * @return \App\Models\Parameter Вернет текущую модель.
     * @since 1.0
     * @version 1.0
     */
    public function clearParameters()
    {
        $this->_parameters = [];

        return $this;
    }

    /**
     * Добавление конкретного параметра.
     *
     * @param string $index Индекс параметра.
     *
     * @return \App\Models\Parameter Вернет текущую модель.
     * @since 1.0
     * @version 1.0
     */
    public function clearParameter(string $index)
    {
        if(isset($this->_parameters[$index])) unset($this->_parameters[$index]);

        return $this;
    }

    /**
     * Возвращает все параметры.
     *
     * @return array Массив параметров.
     * @since 1.0
     * @version 1.0
     */
    public function getParameters(): array
    {
        return $this->_parameters;
    }

    /**
     * Возвращает параметр по индексу.
     *
     * @param string $index Индекс параметра.
     * @param mixed $default Значение по умолчанию.
     *
     * @return mixed Вернет параметр.
     * @since 1.0
     * @version 1.0
     */
    public function getParameter(string $index, $default = null)
    {
        if(isset($this->_parameters[$index])) return $this->_parameters[$index];
        else if(isset($default)) return $default;

        return null;
    }
}