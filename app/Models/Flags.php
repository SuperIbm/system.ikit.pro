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

use Illuminate\Database\Eloquent\Model;

/**
 * Трейт для модели которая поддерживает систему флагов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait Flags
{
    /**
     * Загрузка флаговой системы.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    static function bootFlagsTrait()
    {
        static::saving(function(Model $model)
        {
            $model->flags = empty($model->flags) ? [] : $model->flags;
        });
    }

    /**
     * Перегрузка метода заполнения данными модели.
     *
     * @return mixed Вернет заполненную модель.
     * @version 1.0
     * @since 1.0
     */
    public function getFillable()
    {
        if(!in_array('flags', $this->fillable)) $this->fillable[] = 'flags';

        return parent::getFillable();
    }

    /**
     * Перегрузка метода заполнения данными модели.
     *
     * @return mixed Вернет заполненную модель.
     * @version 1.0
     * @since 1.0
     */
    public function getCasts()
    {
        if(!isset($this->casts['flags'])) $this->casts['flags'] = 'array';

        return parent::getCasts();
    }

    /**
     * Установка значения для флага.
     *
     * @param string $code Индекс значения.
     * @param mixed $value Значения.
     *
     * @return \App\Models\Flags Вернет текущую модель.
     * @version 1.0
     * @since 1.0
     */
    protected function _setFlagValue(string $code, $value)
    {
        $this->setAttribute("flags->{$code}", $value);

        return $this;
    }

    /**
     * Установка значения для флага.
     *
     * @param string $code Индекс значения.
     * @param mixed $value Значения.
     *
     * @return \App\Models\Flags Вернет текущую модель.
     * @version 1.0
     * @since 1.0
     */
    public function setFlag(string $code, $value)
    {
        $this->_setFlagValue($code, $value);

        return $this;
    }

    /**
     * Удаление значения для флага.
     *
     * @param string $code Индекс значения.
     *
     * @return \App\Models\Flags Вернет текущую модель.
     * @version 1.0
     * @since 1.0
     */
    public function unsetFlag(string $code)
    {
        $this->_setFlagValue($code, null);

        return $this;
    }

    /**
     * Получения значения для флага.
     *
     * @param string $code Индекс значения.
     *
     * @return mixed Значение для флага.
     * @version 1.0
     * @since 1.0
     */
    public function getFlag(string $code)
    {
        return isset($this->flags[$code]) ? $this->flags[$code] : null;
    }

    /**
     * Проверка хранит ли флаг true.
     *
     * @param string $code Индекс значения.
     *
     * @return bool Вернет результат проверки.
     * @version 1.0
     * @since 1.0
     */
    public function checkFlag($code): bool
    {
        return (bool)($this->flags[$code] ?? false);
    }

    /**
     * Массовая установка флагов.
     *
     * @param array $value Массив флагов.
     *
     * @return \App\Models\Flags Вернет текущую модель.
     * @version 1.0
     * @since 1.0
     */
    public function setFlags(array $value)
    {
        $this->attributes['flags'] = $this->asJson(array_merge($this->flags ?? [], $value));

        return $this;
    }
}