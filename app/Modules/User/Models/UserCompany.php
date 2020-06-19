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
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Status;
use App\Models\Delete;

/**
 * Класс модель для таблицы компаний пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID компании.
 * @property int|null $user_id ID пользователя.
 * @property string|null $company_name Название компании.
 *
 * @property-read \App\Modules\User\Models\User $user Модель пользователя.
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserCompany whereCompanyName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserCompany whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserCompany whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserCompany whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserCompany withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\UserCompany withoutTrashed()
 *
 * @mixin \Eloquent
 */
class UserCompany extends Eloquent
{
    use Validate, SoftDeletes, Status, Delete;

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
        'user_id',
        'company_name'
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
            'user_id' => 'required|integer|digits_between:1,20',
            'company_name' => 'max:191',
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
            'user_id' => 'ID user',
            'company_name' => 'Company name'
        ];
    }

    /**
     * Получить запись выбранных групп.
     *
     * @return \App\Modules\User\Models\User[]|\Illuminate\Database\Eloquent\Relations\HasOne Модель пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function user()
    {
        return $this->hasOne(User::class);
    }
}