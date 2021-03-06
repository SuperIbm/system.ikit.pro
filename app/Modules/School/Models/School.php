<?php
/**
 * Модуль Школ.
 * Этот модуль содержит все классы для работы школами.
 *
 * @package App\Modules\School
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\School\Models;

use Eloquent;
use App\Models\Validate;
use Size;
use ImageStore;
use Illuminate\Http\UploadedFile;
use App\Models\Status;
use App\Models\Delete;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Modules\User\Models\UserSchool;
use App\Modules\Order\Models\Order;
use App\Modules\Plan\Models\Plan;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Класс модель для таблицы школ на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class School extends Eloquent
{
    use Validate, Status, Delete, SoftDeletes;

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
        'plan_id',
        'image_small_id',
        'image_middle_id',
        'image_big_id',
        'name',
        'index',
        'full_name',
        'description',
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
            'plan_id' => 'required|integer|digits_between:1,20',
            'image_small_id' => 'integer|digits_between:0,20',
            'image_middle_id' => 'integer|digits_between:0,20',
            'image_big_id' => 'integer|digits_between:0,20',
            'name' => 'required|between:1,191',
            'index' => 'required|between:1,191|unique_soft:schools,index,' . $this->id . ',id',
            'full_name' => 'nullable|max:191',
            'description' => 'nullable|max:191',
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
            'user_id' => trans('school::models.school.user_id'),
            'plan_id' => trans('school::models.school.plan_id'),
            'image_small_id' => trans('school::models.school.image_small_id'),
            'image_middle_id' => trans('school::models.school.image_middle_id'),
            'image_big_id' => trans('school::models.school.image_big_id'),
            'name' => trans('school::models.school.name'),
            'index' => trans('school::models.school.index'),
            'full_name' => trans('school::models.school.full_name'),
            'description' => trans('school::models.school.description'),
            'status' => trans('school::models.school.status')
        ];
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
     * Преобразователь атрибута - запись: большое изображение.
     *
     * @param mixed $value Значение атрибута.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setImageBigIdAttribute($value): void
    {
        if(!$value) $this->attributes['image_big_id'] = null;
        else if(is_array($value)) $this->attributes['image_big_id'] = $value['image_big_id'];
        else if(is_numeric($value)) $this->attributes['image_big_id'] = $value;
        else if($value instanceof UploadedFile)
        {
            $path = ImageStore::tmp($value->getClientOriginalExtension());

            Size::make($value)->resize(600, 600, function($constraint)
            {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->crop(600, 600)->save($path);

            if(isset($this->attributes['image_big_id'])) $id = ImageStore::update("school", $this->attributes['image_big_id'], $path);
            else $id = ImageStore::create("school", $path);

            if($id !== false) $this->attributes['image_big_id'] = $id;
        }
    }

    /**
     * Преобразователь атрибута - получение: большое изображение.
     *
     * @param mixed $value Значение атрибута.
     *
     * @return array Среднее изображение.
     * @version 1.0
     * @since 1.0
     */
    public function getImageBigIdAttribute($value): ?array
    {
        if(is_numeric($value)) return ImageStore::get($value);
        else return $value;
    }

    /**
     * Получить роли школы.
     *
     * @return \App\Modules\School\Models\SchoolRole[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели ролей школы.
     * @version 1.0
     * @since 1.0
     */
    public function roles(): HasMany
    {
        return $this->hasMany(SchoolRole::class);
    }

    /**
     * Получить основателя школы.
     *
     * @return \App\Modules\User\Models\User|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель пользователя.
     * @version 1.0
     * @since 1.0
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Получить пользователей школы.
     *
     * @return \App\Modules\User\Models\UserSchool[]|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель пользователей школы.
     * @version 1.0
     * @since 1.0
     */
    public function userSchools(): BelongsTo
    {
        return $this->belongsTo(UserSchool::class);
    }

    /**
     * Получить лимиты школы.
     *
     * @return \App\Modules\School\Models\SchoolLimit[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели лимитов школы.
     * @version 1.0
     * @since 1.0
     */
    public function limits(): HasMany
    {
        return $this->hasMany(SchoolLimit::class);
    }

    /**
     * Получить заказы.
     *
     * @return \App\Modules\Order\Models\Order[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели заказов.
     * @version 1.0
     * @since 1.0
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Получить активные заказы.
     *
     * @return \App\Modules\Order\Models\Order[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели заказов.
     * @version 1.0
     * @since 1.0
     */
    public function activeOrders(): HasMany
    {
        return $this->hasMany(Order::class)
            ->where("from", '<=', Carbon::now())
            ->where
            (
                function($query)
                {
                    /**
                     * @var $query \Illuminate\Database\Eloquent\Builder
                     */
                    $query->where('to', '>=', Carbon::now())
                        ->orWhereNull('to');
                }
            );
    }

    /**
     * Получить тариф.
     *
     * @return \App\Modules\Plan\Models\Plan[]|\Illuminate\Database\Eloquent\Relations\BelongsTo Модели тарифа.
     * @version 1.0
     * @since 1.0
     */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }
}
