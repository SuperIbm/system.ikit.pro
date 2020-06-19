<?php
/**
 * Контракты.
 * Этот пакет содержит контракты ядра системы.
 *
 * @package App.Models.Contracts
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Contracts;

use App\Models\Parameter;
use App\Models\Error;

/**
 * Абстрактный класс позволяющий проектировать собственные классы виджетов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Widget
{
    use Parameter,
        Error;

    /**
     * Шаблон.
     *
     * @var string|int
     * @version 1.0
     * @since 1.0
     */
    private $_template;

    /**
     * Запуск виджета.
     *
     * @return string Вернет результат исполнения.
     * @since 1.0
     * @version 1.0
     */
    abstract public function run(): string;

    /**
     * Установка шаблона.
     *
     * @param string|int $template Шаблон.
     *
     * @return \App\Models\Contracts\Widget Вернет текущий виджет.
     * @since 1.0
     * @version 1.0
     */
    public function setTemplate($template): Widget
    {
        $this->_template = $template;

        return $this;
    }

    /**
     * Получение шаблона.
     *
     * @return string|int Шаблон.
     * @since 1.0
     * @version 1.0
     */
    public function getTemplate()
    {
        return $this->_template;
    }
}