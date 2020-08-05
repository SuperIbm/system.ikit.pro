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

use MongoDb;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Класс модель для таблицы изображений на основе MongoDb.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID изображения.
 * @property int $format Формат изображения.
 * @property int $folder Папка.
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
 * @mixin \MongoDb
 */
class ImageMongoDb extends MongoDb
{
    use Validate, SoftDeletes;

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
    public string $path;

    /**
     * Параметр для хранения пути к файлу без кешь придикаты.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    public string $pathCache;

    /**
     * Параметр для хранения физического пути к файлу.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    public string $pathSource;

    /**
     * Связанная с моделью таблица.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    protected $collection = 'images';

    /**
     * Тип соединения.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    protected $connection = 'mongodb';

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
        'folder',
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
    protected function getRules(): array
    {
        return [
            'folder' => 'required|between:1,191',
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
    protected function getNames(): array
    {
        return [
            'byte' => trans('image::model.image.byte'),
            'folder' => trans('image::model.image.folder'),
            'format' => trans('image::model.image.format'),
            'cache' => trans('image::model.image.cache'),
            'width' => trans('image::model.image.width'),
            'height' => trans('image::model.image.height')
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
    public function setRawAttributes(array $attributes, $sync = false): void
    {
        parent::setRawAttributes($attributes, $sync);
        $this->fireModelEvent('readed');
    }
}
