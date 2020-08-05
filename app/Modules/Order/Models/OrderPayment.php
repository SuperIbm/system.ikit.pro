<?php
/**
 * Модуль Заказов.
 * Этот модуль содержит все классы для работы с заказами.
 *
 * @package App\Modules\Order
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Order\Models;

use Size;
use ImageStore;
use Eloquent;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Status;
use App\Models\Delete;
use Illuminate\Http\UploadedFile;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Класс модель для таблицы систем заказов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @mixin \Eloquent
 */
class OrderPayment extends Eloquent
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
        "id",
        "name",
        "description",
        "parameters",
        "system",
        "online",
        "image_id",
        "status",
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
            'name' => 'required|between:1,191|unique_soft:order_deliveries,name,' . $this->id . ',id',
            'description' => 'max:191',
            'parameters' => 'nullable|json',
            'online' => 'bool',
            'system' => 'required|between:1,191',
            'image_id' => 'integer|digits_between:0,20',
            'status' => 'required|bool'
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
            'name' => trans('order::model.orderPayment.name'),
            'description' => trans('order::model.orderPayment.description'),
            'parameters' => trans('order::model.orderPayment.parameters'),
            'online' => trans('order::model.orderPayment.online'),
            'system' => trans('order::model.orderPayment.system'),
            'image_id' => trans('order::model.orderPayment.image_id'),
            'status' => trans('order::model.orderPayment.status')
        ];
    }

    /**
     * Получить выставленные счета.
     *
     * @return \App\Modules\Order\Models\OrderInvoice[]|\Illuminate\Database\Eloquent\Relations\HasMany Модели выставленных счетов.
     * @version 1.0
     * @since 1.0
     */
    public function invoices(): HasMany
    {
        return $this->hasMany(OrderInvoice::class);
    }

    /**
     * Преобразователь атрибута - запись: изображение.
     *
     * @param mixed $value Значение атрибута.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function setImageIdAttribute($value): void
    {
        if(!$value) $this->attributes['image_id'] = null;
        else if(is_array($value)) $this->attributes['image_id'] = $value['image_id'];
        else if(is_numeric($value)) $this->attributes['image_id'] = $value;
        else if($value instanceof UploadedFile)
        {
            $path = ImageStore::tmp($value->getClientOriginalExtension());

            Size::make($value)->resize(46, 46, function($constraint)
            {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save($path);

            if(isset($this->attributes['image_id'])) $id = ImageStore::update("order_payment", $this->attributes['image_id'], $path);
            else $id = ImageStore::create("order_payment", $path);

            if($id !== false) $this->attributes['image_id'] = $id;
        }
    }

    /**
     * Преобразователь атрибута - получение: изображение.
     *
     * @param mixed $value Значение атрибута.
     *
     * @return array Маленькое изображение.
     * @version 1.0
     * @since 1.0
     */
    public function getImageIdAttribute($value): array
    {
        if(is_numeric($value)) return ImageStore::get($value);
        else return $value;
    }
}
