<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\User\Models;

use Eloquent;
use App\Models\Delete;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\Section\Models\Section;

/**
 * Класс модель для таблицы выбранных разделов роли на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id
 * @property int $user_role_id
 * @property int $section_id
 * @property bool $read Значение статуса на чтение.
 * @property bool $update Значение статуса на обновление.
 * @property bool $create Значение статуса на создание.
 * @property bool $destroy Значение статуса на удаление.
 *
 * @property-read \App\Modules\Section\Models\Section $adminSection
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupSection whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupSection whereSectionId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupSection whereRead($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupSection whereUpdate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupSection whereCreate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserGroupSection whereDestroy($value)
 *
 * @mixin \Eloquent
 */
class UserGroupSection extends Eloquent
{
    use Validate, SoftDeletes, Delete;

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     * @version 1.0
     * @since 1.0
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
        'user_group_id',
        'section_id',
        'read',
        'update',
        'create',
        'destroy'
    ];

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getRules()
    {
        return [
            'user_role_id' => 'required|integer|digits_between:1,20',
            'section_id' => 'required|integer|digits_between:1,20',
            'read' => 'boolean',
            'update' => 'boolean',
            'create' => 'boolean',
            'destroy' => 'boolean'
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getNames()
    {
        return [
            'user_role_id' => 'ID role',
            'section_id' => 'ID section',
            'read' => 'Read',
            'update' => 'Update',
            'create' => 'Create',
            'destroy' => 'Destroy'
        ];
    }

    /**
     * Получить раздел системы.
     *
     * @return \App\Modules\Section\Models\Section|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель разделов административной системы.
     * @version 1.0
     * @since 1.0
     */
    public function section()
    {
        return $this->belongsTo(Section::class, 'id_section');
    }
}
