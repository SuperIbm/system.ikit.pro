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
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Session;
use Size;
use ImageStore;
use Laravel\Passport\HasApiTokens;
use Illuminate\Http\UploadedFile;
use App\Models\Status;
use App\Modules\Order\Models\OrderUser;
use App\Models\Flags;

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
class UserVerification extends Authenticatable
{
    use Validate, Status;

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
        'code',
        'status'
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
            'code' => 'required|max:191',
            'status' => 'required|boolean'
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
            'code' => 'Code',
            'status' => 'Status'
        ];
    }

    /**
     * Получить запись пользователя.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}