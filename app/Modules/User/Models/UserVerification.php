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

use App\Models\Validate;
use Eloquent;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Status;

/**
 * Класс модель для таблицы верификации пользователей на основе Eloquent.
 *
 * @property int $id ID закписи.
 * @property int $user_id ID пользователя.
 * @property string $code Код.
 * @property string $status Статус.
 *
 * @property-read \App\Modules\User\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserVerification whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserVerification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserVerification whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserVerification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserVerification whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserVerification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Modules\User\Models\UserVerification whereUserId($value)
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 * @mixin \Eloquent
 */
class UserVerification extends Eloquent
{
    use Validate, Status;

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
        'code',
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
            'user_id' => 'required|integer|digits_between:1,20',
            'code' => 'required|max:191',
            'status' => 'required|boolean'
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
            'user_id' => trans('user::models.userVerification.user_id'),
            'code' => trans('user::models.userVerification.code'),
            'status' => trans('user::models.userVerification.status')
        ];
    }

    /**
     * Получить запись пользователя.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
