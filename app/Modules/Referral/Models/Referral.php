<?php
/**
 * Модуль Рефералов.
 * Этот модуль содержит все классы для работы с рефералами.
 *
 * @package App\Modules\Referral
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Referral\Models;

use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Delete;
use App\Models\Status;
use App\Modules\User\Models\UserReferral;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс модель для таблицы реферальных программ на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class Referral extends Eloquent
{
    use Validate, SoftDeletes, Delete, Status;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        "id",
        "name",
        "type",
        "price",
        "percentage"
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
            "name" => 'required|between:1,191|unique_soft:referrals,name,' . $this->id . ',id',
            "type" => 'required|between:1,191',
            "price" => "required|float",
            "percentage" => "required|boolean"
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
            "name" => trans('referral::models.referral.name'),
            "type" => trans('referral::models.referral.type'),
            "price" => trans('referral::models.referral.price'),
            "percentage" => trans('referral::models.referral.percentage')
        ];
    }

    /**
     * Получить рефералов пользователей.
     *
     * @return \App\Modules\User\Models\UserReferral|\Illuminate\Database\Eloquent\Relations\HasMany Модели рефералов пользователей.
     * @version 1.0
     * @since 1.0
     */
    public function users(): HasMany
    {
        return $this->hasMany(UserReferral::class);
    }
}
