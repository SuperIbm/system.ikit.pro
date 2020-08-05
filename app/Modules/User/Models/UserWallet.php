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
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс модель для таблицы кошелька пользователя на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class UserWallet extends Eloquent
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
        'user_id',
        'amount',
        'currency'
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
            'amount' => 'required|float',
            'currency' => 'required|in:RUB,USD'
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
            'user_id' => trans('user::model.userWallet.user_id'),
            'amount' => trans('user::model.userWallet.amount'),
            'currency' => trans('user::model.userWallet.currency')
        ];
    }

    /**
     * Получить пользователя.
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
     * Получить исходящие счета.
     *
     * @return \App\Modules\User\Models\UserWalletOutput[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель исходящих счетов.
     * @version 1.0
     * @since 1.0
     */
    public function outputs(): HasMany
    {
        return $this->hasMany(UserWalletOutput::class);
    }

    /**
     * Получить входящие счета.
     *
     * @return \App\Modules\User\Models\UserWalletInput[]|\Illuminate\Database\Eloquent\Relations\HasMany Модель входящих счетов.
     * @version 1.0
     * @since 1.0
     */
    public function inputs(): HasMany
    {
        return $this->hasMany(UserWalletInput::class);
    }
}
