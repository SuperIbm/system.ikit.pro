<?php
/**
 * Модуль предупреждений.
 * Этот модуль содержит все классы для работы с предупреждениями.
 *
 * @package App\Modules\Alert
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Alert\Models;

use Eloquent;
use App\Models\Delete;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Status;
use App\Modules\School\Models\School;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Класс модель для таблицы псевдонимов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID предупреждения.
 * @property string|null $title Заголовок.
 * @property string|null $description Описание.
 * @property string|null $url URL
 * @property string|null $icon Иконка.
 * @property string|null $color Цвет иконки.
 * @property int $status Статус.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereColor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\Alert\Models\Alert whereUrl($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alert\Models\Alert withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Alert\Models\Alert withoutTrashed()
 *
 * @mixin \Eloquent
 */
class Alert extends Eloquent
{
    use Validate, SoftDeletes, Status, Delete;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'school_id',
        'title',
        'description',
        'url',
        'icon',
        'color',
        'status'
    ];

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @return array Массив правил валидации для этой модели.
     * @version 1.0
     * @since 1.0
     */
    protected function getRules(): array
    {
        return [
            'school_id' => 'required|integer|digits_between:1,20',
            'title' => 'required|between:1,191',
            'description' => 'nullable|max:1000',
            'url' => 'nullable|max:191',
            'icon' => 'nullable|max:50',
            'color' => 'nullable|max:50',
            'status' => 'nullable|boolean'
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @return array Массив возможных ошибок валидации.
     * @version 1.0
     * @since 1.0
     */
    protected function getNames(): array
    {
        return [
            'school_id' => trans('user::models.alert.school_id'),
            'pattern' => trans('alert::models.alert.pattern'),
            'description' => trans('alert::models.alert.description'),
            'url' => trans('alert::models.alert.url'),
            'icon' => trans('alert::models.alert.icon'),
            'color' => trans('alert::models.alert.color'),
            'status' => trans('alert::models.alert.status')
        ];
    }

    /**
     * Получить школу.
     *
     * @return \App\Modules\School\Models\School|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель школы.
     * @version 1.0
     * @since 1.0
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
