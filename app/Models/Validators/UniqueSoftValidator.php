<?php
/**
 * Валидирование.
 * Пакет содержит классы для расширения способов валидирования.
 *
 * @package App.Models.Validators
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Validators;

use DB;

/**
 * Классы для валидации уникальных записей для мягкого удаления.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UniqueSoftValidator
{
    /**
     * Валидация.
     *
     * @param string $attribute Название атрибута.
     * @param mixed $value Значение для валидации.
     * @param array $parameters Параметры.
     *
     * @return bool Вернет результат валидации.
     * @since 1.0
     * @version 1.0
     */
    public function validate(?string $attribute, $value, array $parameters): bool
    {
        $value = str_replace(' ', '', $value);
        $value = strtolower($value);
        $queries = DB::table($parameters[0])
            ->selectRaw($parameters[0] . ".*, LOWER(TRIM(`{$parameters[1]}`)) as `{$parameters[1]}`");

        for($i = 3; $i < count($parameters); $i = $i + 2)
        {
            if(isset($parameters[$i + 1])) $queries->where($parameters[$i], $parameters[$i + 1]);
        }

        $queries->where("deleted_at", '=', null);

        $queries = $queries->get();
        $nameParam = @$parameters[3];

        foreach($queries as $query)
        {
            if($value == $query->{$parameters[1]} && !$nameParam) return false;
            else if($value == $query->{$parameters[1]} && $query->{$nameParam} != $parameters[2]) return false;
        }

        return true;
    }
}
