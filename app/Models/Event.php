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
 * Трейт позволяющий добавлять и запускать события внутри модели.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait Event
{
    /**
     * Объект интерфейса определяющий методы для добавления, удаления и оповещения наблюдателей.
     *
     * @var \App\Models\Observable
     * @version 1.0
     * @since 1.0
     */
    private Observable $_observable;

    /**
     * Инициализация объекта интерфейса определяющего методы для добавления, удаления и оповещения наблюдателей.
     *
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    private function _init()
    {
        if(!$this->_observable) $this->_observable = new Observable();

        return $this;
    }

    /**
     * Добавление событий.
     *
     * @param string $action Название события. Если $function пуст, то реализация события происходит через одноименный метод.
     * @param callable $function Функция, которая должна быть вызвана для этого события.
     *
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function addEvent(string $action, callable $function = null)
    {
        $this->_init();
        $this->_observable->add($this, $action, $function);
        return $this;
    }

    /**
     * Удаление события.
     *
     * @param string $action Название события.
     *
     * @return $this
     * @since 1.0
     * @version 1.0
     */
    public function deleteEvent(string $action)
    {
        $this->_init();
        $this->_observable->delete($action);
        return $this;
    }

    /**
     * Проверить если такое событие.
     *
     * @param string $action Название события.
     *
     * @return bool Вернет true если событие для наблюдателя существует.
     * @since 1.0
     * @version 1.0
     */
    public function hasEvent(string $action): bool
    {
        $this->_init();
        return $this->_observable->has($action);
    }

    /**
     * Запуск события и возращения всех значений.
     *
     * @param string $action Название события.
     * @param array $params Параметры события, которые передаются в его реализацию.
     *
     * @return mixed Вернет все возращенные значения реализаций.
     * @since 1.0
     * @version 1.0
     */
    public function fireEvent(string $action, array $params = [])
    {
        $this->_init();
        return $this->_observable->fire($action, $params);
    }

    /**
     * Запуск события и возращения только первого значения.
     *
     * @param string $action Название события.
     * @param array $params Параметры события, которые передаются в его реализацию.
     *
     * @return mixed Вернет первое возращенное значения реализаций.
     * @since 1.0
     * @version 1.0
     */
    public function firstEvent(string $action, array $params = [])
    {
        $this->_init();
        return $this->_observable->first($action, $params);
    }

    /**
     * Запуск события и их исполнение до первого возращенного false.
     *
     * @param string $action Название события.
     * @param array $params Параметры события, которые передаются в его реализацию.
     *
     * @return mixed Вернет первое возращенное значения реализаций.
     * @since 1.0
     * @version 1.0
     */
    public function untilEvent(string $action, array $params = [])
    {
        $this->_init();
        return $this->_observable->until($action, $params);
    }
}
