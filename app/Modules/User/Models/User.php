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
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Size;
use ImageStore;
use Illuminate\Http\UploadedFile;
use App\Models\Status;
use App\Models\Flags;
use App\Models\Delete;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс модель для таблицы пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id
 * @property int $image_small_id Маленькое изображение.
 * @property int $image_middle_id Среднее изображение.
 * @property string $login Логин.
 * @property string $password Расшифрованный пароль.
 * @property string $remember_token Токен.
 * @property string $first_name Имя.
 * @property string $second_name Фамилия.
 * @property string $telephone Телефон.
 * @property bool $two_factor Двухфакторная аутентификация.
 * @property bool $status Значение статуса.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserVerification $verification
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Modules\User\Models\UserRecovery $recovery
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereImageSmallId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereImageMiddleId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereLogin($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereFirstname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereSecondname($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereTelephone($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User whereStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\User active($status = true)
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Validate, Notifiable, Status, Flags, Delete, SoftDeletes;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'image_small_id',
        'image_middle_id',
        'login',
        'password',
        'remember_token',
        'first_name',
        'second_name',
        'telephone',
        'two_factor',
        'status',
        'flags'
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
            'image_small_id' => 'integer|digits_between:0,20',
            'image_middle_id' => 'integer|digits_between:0,20',
            'login' => 'required|email|between:1,191|unique_soft:users,login,' . $this->id . ',id',
            'password' => 'required',
            'first_name' => 'nullable|max:150',
            'second_name' => 'nullable|max:150',
            'telephone' => 'nullable|max:30',
            'two_factor' => 'nullable|boolean',
            'status' => 'required|min:0|max:2'
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
            'image_small_id' => trans('user::models.user.image_small_id'),
            'image_middle_id' => trans('user::models.user.image_middle_id'),
            'login' => trans('user::models.user.login'),
            'password' => trans('user::models.user.password'),
            'remember_token' => trans('user::models.user.remember_token'),
            'first_name' => trans('user::models.user.first_name'),
            'second_name' => trans('user::models.user.second_name'),
            'telephone' => trans('user::models.user.telephone'),
            'two_factor' => trans('user::models.user.two_factor'),
            'status' => trans('user::models.user.status')
        ];
    }

    /**
     * Определяем свойство, которое хранит значение в модели для канала отправки сообщения по средствам телефона.
     *
     * @return string
     * @version 1.0
     * @since 1.0
     */
    public function routeNotificationForPhone(): ?string
    {
        return $this->telephone;
    }

    /**
     * Определяем свойство, которое хранит значение в модели для канала отправки сообщения по средствам e-mail.
     *
     * @return string
     * @version 1.0
     * @since 1.0
     */
    public function routeNotificationForMail(): ?string
    {
        return $this->login;
    }

    /**
     * Определяем свойство, которое хранит значение в модели для канала отправки сообщения по средствам Nexmo.
     *
     * @return string
     * @version 1.0
     * @since 1.0
     */
    public function routeNotificationForNexmo(): ?string
    {
        return $this->telephone;
    }

    /**
     * Преобразователь атрибута - запись: маленькое изображение.
     *
     * @param mixed $value Значение атрибута.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setImageSmallIdAttribute($value): void
    {
        if(!$value) $this->attributes['image_small_id'] = null;
        else if(is_array($value)) $this->attributes['image_small_id'] = $value['image_small_id'];
        else if(is_numeric($value)) $this->attributes['image_small_id'] = $value;
        else if($value instanceof UploadedFile)
        {
            $path = ImageStore::tmp($value->getClientOriginalExtension());

            Size::make($value)->resize(60, 60, function($constraint)
            {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(60, 60)->save($path);

            if(isset($this->attributes['image_small_id'])) $id = ImageStore::update("school", $this->attributes['image_small_id'], $path);
            else $id = ImageStore::create("school", $path);

            if($id !== false) $this->attributes['image_small_id'] = $id;
        }
    }

    /**
     * Преобразователь атрибута - получение: маленькое изображение.
     *
     * @param mixed $value Значение атрибута.
     *
     * @return array Маленькое изображение.
     * @version 1.0
     * @since 1.0
     */
    public function getImageSmallIdAttribute($value): ?array
    {
        if(is_numeric($value)) return ImageStore::get($value);
        else return $value;
    }

    /**
     * Преобразователь атрибута - запись: среднее изображение.
     *
     * @param mixed $value Значение атрибута.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setImageMiddleIdAttribute($value): void
    {
        if(!$value) $this->attributes['image_middle_id'] = null;
        else if(is_array($value)) $this->attributes['image_middle_id'] = $value['image_middle_id'];
        else if(is_numeric($value)) $this->attributes['image_middle_id'] = $value;
        else if($value instanceof UploadedFile)
        {
            $path = ImageStore::tmp($value->getClientOriginalExtension());

            Size::make($value)->resize(300, 300, function($constraint)
            {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(300, 300)->save($path);

            if(isset($this->attributes['image_middle_id'])) $id = ImageStore::update("school", $this->attributes['image_middle_id'], $path);
            else $id = ImageStore::create("school", $path);

            if($id !== false) $this->attributes['image_middle_id'] = $id;
        }
    }

    /**
     * Преобразователь атрибута - получение: среднее изображение.
     *
     * @param mixed $value Значение атрибута.
     *
     * @return array Среднее изображение.
     * @version 1.0
     * @since 1.0
     */
    public function getImageMiddleIdAttribute($value): ?array
    {
        if(is_numeric($value)) return ImageStore::get($value);
        else return $value;
    }

    /**
     * Получение адреса пользоватеяля.
     *
     * @return \App\Modules\User\Models\UserAddress|\Illuminate\Database\Eloquent\Relations\HasOne Модель адреса пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function userAddress(): HasOne
    {
        return $this->hasOne(UserAddress::class);
    }

    /**
     * Получить запись верификации.
     *
     * @return \App\Modules\User\Models\UserVerification|\Illuminate\Database\Eloquent\Relations\HasOne Модель верификации пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function verification(): HasOne
    {
        return $this->hasOne(UserVerification::class);
    }

    /**
     * Получить запись восствновления пароля пользователя.
     *
     * @return \App\Modules\User\Models\UserRecovery|\Illuminate\Database\Eloquent\Relations\HasOne Модель восствновления пароля пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function recovery(): HasOne
    {
        return $this->hasOne(UserRecovery::class);
    }

    /**
     * Получить школы пользователя.
     *
     * @return \App\Modules\User\Models\UserSchool[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели школ.
     * @version 1.0
     * @since 1.0
     */
    public function schools(): HasMany
    {
        return $this->hasMany(UserSchool::class);
    }

    /**
     * Получить школьные роли пользователя.
     *
     * @return \App\Modules\User\Models\UserSchoolRole[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели школьных ролей пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function schoolRoles(): HasMany
    {
        return $this->hasMany(UserSchoolRole::class);
    }

    /**
     * Получить кошелек.
     *
     * @return \App\Modules\User\Models\UserWallet|\Illuminate\Database\Eloquent\Relations\HasOne Модель кошелька.
     * @version 1.0
     * @since 1.0
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(UserWallet::class);
    }

    /**
     * Получить рефералы выступая в роли приглашенного.
     *
     * @return \App\Modules\User\Models\UserReferral|\Illuminate\Database\Eloquent\Relations\HasMany Модель рефералов.
     * @version 1.0
     * @since 1.0
     */
    public function referralInvited(): HasMany
    {
        return $this->hasMany(UserReferral::class, "id", "user_invited_id");
    }

    /**
     * Получить рефералы выступая в роли приглашающего.
     *
     * @return \App\Modules\User\Models\UserReferral|\Illuminate\Database\Eloquent\Relations\HasMany Модель рефералов.
     * @version 1.0
     * @since 1.0
     */
    public function referralInviting(): HasMany
    {
        return $this->hasMany(UserReferral::class, "id", "user_inviting_id");
    }

    /**
     * Получить аунтификации пользователя.
     *
     * @return \App\Modules\User\Models\UserAuth|\Illuminate\Database\Eloquent\Relations\HasMany Модель аунтификаций пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function auths(): HasMany
    {
        return $this->hasMany(UserAuth::class);
    }
}
