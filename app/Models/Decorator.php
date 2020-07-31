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

use App\Models\Contracts\Pipe;

/**
 * Класс для создания собственного декоратора
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Decorator
{
    use Parameter, Error;

    /**
     * Массив действий.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    private $_actions = [];

    /**
     * Метод обработчик собития после выполнения всех действий декоратора.
     *
     * @return array|boolean Верент массив данных при выполнении действия.
     * @since 1.0
     * @version 1.0
     */
    abstract public function run();

    /**
     * Добавление действий.
     *
     * @param array $actions Массив действий.
     *
     * @return \App\Models\Decorator Возвращает теущий объект.
     * @version 1.0
     * @since 1.0
     */
    public function setActions(array $actions)
    {
        $this->_actions = $actions;

        return $this;
    }

    /**
     * Добавляем одно действие для установки.
     *
     * @param Pipe $action Действие для установки.
     *
     * @return \App\Models\Decorator Возвращает теущий объект.
     * @version 1.0
     * @since 1.0
     */
    public function addAction(Pipe $action)
    {
        $this->_actions = $action;

        return $this;
    }

    /**
     * Возвращает все действия.
     *
     * @return \App\Models\Decorator Вернет все действия.
     * @version 1.0
     * @since 1.0
     */
    public function getActions(): array
    {
        return $this->_actions;
    }
}
