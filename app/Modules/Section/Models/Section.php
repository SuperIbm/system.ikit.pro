<?php
/**
 * Модуль Разделы системы.
 * Этот модуль содержит все классы для работы с разделами системы.
 *
 * @package App\Modules\Section
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Section\Models;

use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\User\Models\UserRoleSection;
use Kalnoy\Nestedset\NodeTrait;
use App\Models\Status;
use App\Models\Delete;

/**
 * Класс модель для таблицы разделов системы на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID секции системы.
 * @property string $label Лейбел секции.
 * @property string $bundle Пакет раздела системы.
 * @property string $icon Иконка.
 * @property bool $weight Вес раздела в меню системы.
 * @property string $status Значение статуса.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRoleSection[] $userRoleSections
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Section\Models\Section whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Section\Models\Section whereNameSection($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Section\Models\Section whereLabel($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Section\Models\Section whereBundle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Section\Models\Section whereIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Section\Models\Section whereWeight($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Section\Models\Section whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Section\Models\Section active($status = true)
 *
 * @mixin \Eloquent
 */
class Section extends Eloquent
{
    use Validate, SoftDeletes, Status, Delete, NodeTrait;

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     * @since 1.0
     * @version 1.0
     */
    public $timestamps = true;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'parent_id',
        "index",
        'label',
        'icon',
        'status'
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
            'parent_id' => 'integer|digits_between:0,20',
            'label' => 'required|between:1,191',
            'index' => 'required|between:1,191|unique_soft:admin_sections,index,' . $this->id . ',id',
            'icon' => 'max:191',
            'status' => 'required|boolean'
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
            'parent_id' => trans('section::models.section.parent_id'),
            'index' => trans('section::models.section.index'),
            'label' => trans('section::models.section.label'),
            'icon' => trans('section::models.section.icon'),
            'status' => trans('section::models.section.status')
        ];
    }

    /**
     * Получить запись выбранных разделов системы.
     *
     * @return \App\Modules\User\Models\UserRoleSection[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель выбранных разделов системы.
     * @version 1.0
     * @since 1.0
     */
    public function userRoleSections()
    {
        return $this->hasMany(UserRoleSection::class);
    }
}
