<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 *
 * @package App\Modules\Core
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Core\Models;

use Illuminate\Console\Command;
use App\Models\Contracts\Pipe;
use Illuminate\Pipeline\Pipeline;
use App\Models\Parameter;

/**
 * Класс установщик, позволяет установить систему.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Installer
{
    use Parameter;

    /**
     * Консоль.
     *
     * @var \Illuminate\Console\Command
     * @version 1.0
     * @since 1.0
     */
    private $_command;

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
     * @return bool Должен вернуть true, для успешности действия.
     * @since 1.0
     * @version 1.0
     */
    public function run()
    {
        $this->setParameters
        (
            [
                "command" => $this->getCommand(),
                "result" => []
            ]
        );

        app(Pipeline::class)->send($this->getParameters())->through($this->getActions())->then(function()
        {
            $this->getCommand()->info('The system has been successfully installed.');
            $this->getCommand()->info('You can now login with your username and password at /admin.');
        });

        return true;
    }

    /**
     * Добавление действий.
     *
     * @param array $actions Массив действий.
     *
     * @return Installer Возвращает объект установки.
     * @version 1.0
     * @since 1.0
     */
    public function setActions(array $actions): Installer
    {
        $this->_actions = $actions;

        return $this;
    }

    /**
     * Добавляем одно действие для установки.
     *
     * @param Pipe $action Действие для установки.
     *
     * @return Installer Возвращает объект установки.
     * @version 1.0
     * @since 1.0
     */
    public function addAction(Pipe $action): Installer
    {
        $this->_actions = $action;

        return $this;
    }

    /**
     * Возвращает все действия.
     *
     * @return array Вернет все действия.
     * @version 1.0
     * @since 1.0
     */
    public function getActions(): array
    {
        return $this->_actions;
    }

    /**
     * Установка консоли.
     *
     * @param \Illuminate\Console\Command $Command Консоль.
     *
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function setCommand(Command $Command)
    {
        $this->_command = $Command;
        return $this;
    }


    /**
     * Установка консоли.
     *
     * @return \Illuminate\Console\Command $Command Консоль.
     * @since 1.0
     * @version 1.0
     */
    public function getCommand()
    {
        return $this->_command;
    }
}
