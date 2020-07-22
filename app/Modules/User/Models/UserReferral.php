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
use App\Models\Delete;
use App\Modules\Referral\Models\Referral;

/**
 * Класс модель для таблицы рефералов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class UserReferral extends Eloquent
{
    use Validate, SoftDeletes, Delete;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'referral_id',
        'user_invited_id',
        'user_inviting_id'
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
            'referral_id' => 'required|integer|digits_between:1,20',
            'user_invited_id' => 'required|integer|digits_between:1,20',
            'user_inviting_id' => 'required|integer|digits_between:1,20',
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
            'referral_id' => trans('user::model.userReferral.referral_id'),
            'user_invited_id' => trans('user::model.userReferral.user_invited_id'),
            'user_inviting_id' => trans('user::model.userReferral.user_inviting_id')
        ];
    }

    /**
     * Получить реферальную программу.
     *
     * @return \App\Modules\Referral\Models\Referral|\Illuminate\Database\Eloquent\Relations\BelongsTo Получить реферальную программу.
     * @version 1.0
     * @since 1.0
     */
    public function referral()
    {
        return $this->belongsTo(Referral::class);
    }

    /**
     * Получить приглашшеного пользователя.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\BelongsTo Модели пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function invited()
    {
        return $this->belongsTo(User::class, "user_invited_id", "id");
    }

    /**
     * Получить пользователя что пригласил.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\BelongsTo Модели пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function inviting()
    {
        return $this->belongsTo(User::class, "user_inviting_id", "id");
    }
}
