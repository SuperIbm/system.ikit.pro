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

use Validator;

/**
 * Трейт автовалидирования модели.
 * Данный трет позволяет расширить возможности модели для автоматической валидации при добавлении информации.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait Validate
{
    use Error;

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @return array Массив правил валидации для этой модели.
     * @version 1.0
     * @since 1.0
     */
    abstract protected function getRules(): array;


    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @return array Массив названий атрибутов.
     * @version 1.0
     * @since 1.0
     */
    abstract protected function getNames(): array;


    /**
     * Метод, который должен вернуть все сообщения об ошибках.
     *
     * @return array Массив возможных ошибок валидации.
     * @version 1.0
     * @since 1.0
     */
    protected function getMessages(): array
    {
        return [];
    }


    /**
     * Обработчик загрузки.
     * Предназначен для настройки обработчика при сохраненнии.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    protected static function boot()
    {
        parent::boot();

        static::saving(function($model)
        {
            $status = $model->validate();

            if(!$status) return false;
        });
    }


    /**
     * Валидирование текущих атрибутов.
     *
     * @return bool Если валидация прошла успешно вернет true.
     * @since 1.0
     * @version 1.0
     */
    public function validate(): bool
    {
        $attributes = $this->getAttributes();

        foreach($attributes as $k => $v)
        {
            if(is_null($v)) unset($attributes[$k]);
        }

        $Valided = Validator::make($attributes, static::getRules(), static::getMessages(), static::getNames());

        if($Valided->passes()) return true;

        $errors = $Valided->messages()->toArray();

        foreach($errors as $key => $value)
        {
            for($i = 0; $i < count($value); $i++)
            {
                $this->addError('validate', $value[$i], $key);
            }
        }

        return false;
    }
}
