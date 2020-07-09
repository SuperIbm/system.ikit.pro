<?php
/**
 * Модуль Запоминания действий.
 * Этот модуль содержит все классы для работы с запоминанием и контролем действий пользователя.
 *
 * @package App\Modules\Act
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Act\Models;

use Eloquent;
use App\Models\Validate;
use App\Models\Delete;

/**
 * Класс модель для действий на основе Eloquent.
 *
 * @property int $id ID.
 * @property string $index Index.
 * @property int $count Count.
 * @property int $minutes Minutes.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Act\Models\Act whereCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Act\Models\Act whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Act\Models\Act whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Act\Models\Act whereIndex($value)
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class Act extends Eloquent
{
    use Validate, Delete;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'index',
        'count',
        'minutes'
    ];

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getRules(): array
    {
        return [
            'index' => 'required|between:1,255|unique:acts,index,' . $this->id . ',id',
            'count' => 'required|integer',
            'minutes' => 'required|integer'
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getNames(): array
    {
        return [
            'index' => trans('act::models.act.index'),
            'count' => trans('act::models.act.count'),
            'minutes' => trans('act::models.act.Minutes')
        ];
    }
}
