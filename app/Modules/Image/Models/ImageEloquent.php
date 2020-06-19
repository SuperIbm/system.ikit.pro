<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Models;

use Eloquent;
use App\Models\Delete;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * Класс модель для таблицы изображений на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID изображения.
 * @property int $format Формат изображения.
 * @property mixed $byte Байт код изображения.
 * @property string $cache Предиката для кеширования.
 * @property int $width Ширина изображения.
 * @property int $height Высота изображения.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereIdImage($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereByte($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereFormat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereCache($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereWidth($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Image\Models\ImageEloquent whereHeight($value)
 *
 * @mixin \Eloquent
 */
class ImageEloquent extends Eloquent
{
    use Validate, SoftDeletes, Delete;

    /**
     * Название таблицы базы данных.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    protected $table = "images";

    /**
     * Параметр для хранения пути к файлу.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    public $path;

    /**
     * Параметр для хранения пути к файлу без кешь придикаты.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    public $pathCache;

    /**
     * Параметр для хранения физического пути к файлу.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    public $pathSource;

    /**
     * Определяет необходимость отметок времени для модели.
     *
     * @var bool
     * @since 1.0
     * @version 1.0
     */
    public $timestamps = true;

    /**
     * Расширенные пользователькие события.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $observables = ['readed'];

    /**
     * Атрибуты, для которых разрешено массовое назначение.
     *
     * @var array
     * @since 1.0
     * @version 1.0
     */
    protected $fillable = [
        'id',
        'byte',
        'format',
        'cache',
        'width',
        'height'
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
            'format' => 'required|between:1,20',
            'cache' => 'max:50',
            'width' => 'integer|digits_between:1,5',
            'height' => 'integer|digits_between:1,5'
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
            'byte' => 'Bytes',
            'format' => 'Format',
            'cache' => 'Cache',
            'width' => 'Width',
            'height' => 'Height'
        ];
    }

    /**
     * Перегружаем стандартный метод для возможности запуска события на чтение.
     *
     * @param array $attributes Значения атрибутов.
     * @param bool $sync Синхронизировать.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function setRawAttributes(array $attributes, $sync = false)
    {
        parent::setRawAttributes($attributes, $sync);
        $this->fireModelEvent('readed');
    }
}
