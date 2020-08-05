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
class UserWalletInput extends Eloquent
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
        'amount'
    ];

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getRules(): array
    {
        return [
            'user_wallet_id' => 'required|integer|digits_between:1,20',
            'amount' => 'required|float'
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @version 1.0
     * @since 1.0
     */
    protected function getNames(): array
    {
        return [
            'user_wallet_id' => trans('user::model.userWalletInput.user_wallet_id'),
            'amount' => trans('user::model.userWalletInput.amount')
        ];
    }

    /**
     * Получить кошелек.
     *
     * @return \App\Modules\User\Models\UserWallet|\Illuminate\Database\Eloquent\Relations\BelongsTo Модель кошелька.
     * @version 1.0
     * @since 1.0
     */
    public function wallet()
    {
        return $this->belongsTo(UserWallet::class);
    }
}
