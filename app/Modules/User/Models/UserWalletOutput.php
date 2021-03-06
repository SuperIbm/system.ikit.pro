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
use App\Modules\Order\Models\OrderCharge;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Класс модель для таблицы приходов в кошелек на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class UserWalletOutput extends Eloquent
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
        'user_wallet_id',
        'order_charge_id',
        'amount'
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
            'user_wallet_id' => 'required|integer|digits_between:1,20',
            'order_charge_id' => 'required|integer|digits_between:1,20',
            'amount' => 'required|float'
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @return array Массив возможных ошибок валидации.
     * @return array Массив возможных ошибок валидации.
     * @version 1.0
     * @since 1.0
     */
    protected function getNames(): array
    {
        return [
            'user_wallet_id' => trans('user::models.userWalletOutput.user_wallet_id'),
            'order_charge_id' => trans('user::models.userWalletOutput.order_charge_id'),
            'amount' => trans('user::models.userWalletOutput.amount')
        ];
    }

    /**
     * Получить оплаченный счет.
     *
     * @return \App\Modules\Order\Models\OrderCharge|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель кошелька.
     * @version 1.0
     * @since 1.0
     */
    public function charge(): BelongsTo
    {
        return $this->belongsTo(OrderCharge::class);
    }

    /**
     * Получить кошелек.
     *
     * @return \App\Modules\User\Models\UserWallet|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель кошелька.
     * @version 1.0
     * @since 1.0
     */
    public function wallet(): BelongsTo
    {
        return $this->belongsTo(UserWallet::class);
    }
}
