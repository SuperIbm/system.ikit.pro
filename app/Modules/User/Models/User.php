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
use Size;
use ImageStore;
use Illuminate\Http\UploadedFile;
use App\Models\Status;
use App\Modules\Order\Models\OrderUser;
use App\Models\Flags;
use App\Models\Delete;

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
 * @property string $email E-mail
 * @property string $telephone Телефон.
 * @property string $status Значение статуса.
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
    use Validate, Notifiable, Status, Flags, Delete;

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
        'image_small_id',
        'image_middle_id',
        'login',
        'password',
        'remember_token',
        'first_name',
        'second_name',
        'email',
        'telephone',
        'status',
        'flags'
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
            'image_small_id' => 'integer|digits_between:0,20',
            'image_middle_id' => 'integer|digits_between:0,20',
            'login' => 'required|between:1,191|unique_soft:users,login,' . $this->id . ',id',
            'password' => 'required',
            'first_name' => 'nullable|max:150',
            'second_name' => 'nullable|max:150',
            'email' => 'nullable|email',
            'telephone' => 'nullable|max:30',
            'status' => 'required|min:0|max:2'
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
            'image_small_id' => 'Small image',
            'image_middle_id' => 'Middle image',
            'login' => 'Login',
            'password' => 'Password',
            'remember_token' => 'Token',
            'first_name' => 'Firstname',
            'second_name' => 'Inchagov',
            'email' => 'E-mail',
            'telephone' => 'Telephone',
            'status' => 'Status'
        ];
    }

    /**
     * Определяем свойство, которое хранит значение в модели для канала отправки сообщения по средствам телефона.
     *
     * @return string
     * @version 1.0
     * @since 1.0
     */
    public function routeNotificationForPhone()
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
    public function routeNotificationForMail()
    {
        return $this->email;
    }

    /**
     * Определяем свойство, которое хранит значение в модели для канала отправки сообщения по средствам Nexmo.
     *
     * @return string
     * @version 1.0
     * @since 1.0
     */
    public function routeNotificationForNexmo()
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
    public function setImageSmallIdAttribute($value)
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

            if(isset($this->attributes['image_small_id'])) $id = ImageStore::update($this->attributes['image_small_id'], $path);
            else $id = ImageStore::create($path);

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
    public function getImageSmallIdAttribute($value)
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
    public function setImageMiddleIdAttribute($value)
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

            if(isset($this->attributes['image_middle_id'])) $id = ImageStore::update($this->attributes['image_middle_id'], $path);
            else $id = ImageStore::create($path);

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
    public function getImageMiddleIdAttribute($value)
    {
        if(is_numeric($value)) return ImageStore::get($value);
        else return $value;
    }

    /**
     * Получить запись выбранных групп для пользователя.
     *
     * @return \App\Modules\User\Models\UserGroupUser[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель выбраные группы для пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function userGroupUsers()
    {
        return $this->hasMany(UserGroupUser::class);
    }

    /**
     * Получение всех групп пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough Модель групп пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function userGroups()
    {
        return $this->hasManyThrough(UserGroup::class, UserGroupUser::class, "user_id", "id");
    }

    /**
     * Получение всех ролей пользователя.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough Модель ролей пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function userGroupRoles()
    {
        return $this->hasManyThrough(UserGroupRole::class, UserGroupUser::class, "user_id", "user_group_id", "id", "user_group_id");
    }

    /**
     * Получение адреса пользоватеяля.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne Модель адреса пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function userAddress()
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
    public function verification()
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
    public function recovery()
    {
        return $this->hasOne(UserRecovery::class);
    }
}
