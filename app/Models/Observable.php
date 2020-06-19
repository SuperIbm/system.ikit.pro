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
 * Класс интерфейс, определяющий методы для добавления, удаления и оповещения наблюдателей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Observable
{
    /**
     * Массив всех наблюдателей.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    protected $_observers = [];

    /**
     * Добавление наблюдателя.
     *
     * @param object $observer Объект наблюдатель, в котором будет реализовано событие.
     * @param string $action Название действия. Если $function пуст, то реализация события происходит через одноименный метод.
     * @param callable $function Функция, которая должна быть вызвана для этого события.
     *
     * @return \App\Models\Observable Возвращает интерфейс наблюдателя.
     * @since 1.0
     * @version 1.0
     */
    public function add($observer, string $action, $function = null): Observable
    {
        if(!isset($this->_observers[$action])) $this->_observers[$action] = Array();

        $ln = count($this->_observers[$action]);

        $this->_observers[$action][$ln] = Array();
        $this->_observers[$action][$ln]["obj"] = $observer;
        $this->_observers[$action][$ln]["function"] = $function;

        return $this;
    }


    /**
     * Удаление действия наблюдателя.
     *
     * @param string $action Название действия.
     *
     * @return \App\Models\Observable Возвращает интерфейс наблюдателя.
     * @since 1.0
     * @version 1.0
     */
    public function delete(string $action): Observable
    {
        if(isset($this->_observers[$action])) unset($this->_observers[$action]);

        return $this;
    }


    /**
     * Проверить если такое действие у наблюдателя.
     *
     * @param string $action Название действия.
     *
     * @return bool Вернет true если действие для наблюдателя существует.
     * @since 1.0
     * @version 1.0
     */
    public function has(string $action): bool
    {
        if(isset($this->_observers[$action])) return true;
        else return false;
    }


    /**
     * Запуск действия.
     *
     * @param string $action Название действия.
     * @param array $params Параметры действия, которые передаются в его реализацию.
     * @param bool $stopIfFalse Если указать true, то нужно остановить выполнение действия если хотя бы одна реализация вернула false.
     *
     * @return mixed Вернет все возращенные значения реализаций.
     * @since 1.0
     * @version 1.0
     */
    protected function _start(string $action, $params = [], $stopIfFalse = false)
    {
        if(isset($this->_observers[$action]))
        {
            $values = Array();

            for($i = 0; $i < count($this->_observers[$action]); $i++)
            {
                if($this->_observers[$action][$i]["function"]) $has = true;
                else $has = method_exists($this->_observers[$action][$i]["obj"], $action);

                if($has == true)
                {
                    array_unshift($params, $this->_observers[$action][$i]["obj"]);

                    if($this->_observers[$action][$i]["function"]) $values[] = call_user_func_array($this->_observers[$action][$i]["function"],
                        $params);
                    else $values[] = call_user_func_array(array($this->_observers[$action][$i]["obj"], $action),
                        $params);

                    if($stopIfFalse == true && $values[count($values) - 1] === false) break;
                }
            }

            if(count($values) > 0) return $values;
            else return true;
        }

        return true;
    }


    /**
     * Запуск действия и возращения всех значений.
     *
     * @param string $action Название действия.
     * @param array $params Параметры действия, которые передаются в его реализацию.
     *
     * @return mixed Вернет все возращенные значения реализаций.
     * @since 1.0
     * @version 1.0
     */
    public function fire(string $action, $params = [])
    {
        $values = $this->_start($action, $params);
        return $values;
    }


    /**
     * Запуск действия и возращения только первого значения.
     *
     * @param string $action Название действия.
     * @param array $params Параметры действия, которые передаются в его реализацию.
     *
     * @return mixed Вернет первое возращенное значения реализаций.
     * @since 1.0
     * @version 1.0
     */
    public function first(string $action, $params = [])
    {
        $values = $this->_start($action, $params);

        if(is_array($values)) return $values[0];
        else return true;
    }


    /**
     * Запуск действия и их исполнение до первого возращенного false.
     *
     * @param string $action Название действия.
     * @param array $params Параметры действия, которые передаются в его реализацию.
     *
     * @return mixed Вернет первое возращенное значения реализаций.
     * @since 1.0
     * @version 1.0
     */
    public function until(string $action, $params = [])
    {
        $values = $this->_start($action, $params, true);

        if(is_array($values)) return $values[0];
        else return true;
    }
}