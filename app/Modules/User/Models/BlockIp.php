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
use App\Models\Status;
use App\Models\Delete;

/**
 * Класс модель для таблицы блокированных IP адресов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID блокированного IP адреса.
 * @property string $ip Маски IP адреса.
 * @property string $status Значение статуса.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\BlockIp active($status = true)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\BlockIp whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\BlockIp whereIp($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\User\Models\BlockIp whereStatus($value)
 *
 * @mixin \Eloquent
 */
class BlockIp extends Eloquent
{
    use Validate, SoftDeletes, Status, Delete;

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'ip',
        'status'
    ];

    /**
     * Метод, который должен вернуть все правила валидации.
     *
     * @return array Вернет массив правил.
     * @see \App\Models\Validate::getRules
     * @version 1.0
     * @since 1.0
     */
    protected function getRules(): array
    {
        return [
            'ip' => 'required|ipMask|unique_soft:block_ips,ip,' . $this->id . ',id',
            'status' => 'required|boolean'
        ];
    }

    /**
     * Метод, который должен вернуть все названия атрибутов.
     *
     * @see \App\Models\Validate::getNames
     * @version 1.0
     * @since 1.0
     */
    protected function getNames(): array
    {
        return [
            'ip' => trans('user::model.blockIp.ip'),
            'status' => trans('user::model.blockIp.status')
        ];
    }
}
