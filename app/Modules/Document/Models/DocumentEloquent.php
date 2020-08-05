<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Models;

use Eloquent;
use App\Models\Delete;
use App\Models\Validate;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Класс модель для таблицы документов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 *
 * @property int $id ID документа.
 * @property int $folder Папка.
 * @property mixed $byte Байт код документа.
 * @property mixed $format Формат документа.
 * @property string $cache Предиката для кеширования.
 *
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Document\Models\DocumentEloquent whereIdDocument($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Document\Models\DocumentEloquent whereByte($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Document\Models\DocumentEloquent whereFormat($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Modules\Document\Models\DocumentEloquent whereCache($value)
 *
 * @mixin \Eloquent
 */
class DocumentEloquent extends Eloquent
{
    use Validate, SoftDeletes, Delete;

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
     * Связанная с моделью таблица.
     *
     * @var string
     * @since 1.0
     * @version 1.0
     */
    protected $table = 'documents';

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
        'folder'
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
            'folder' => 'required|between:1,191'
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
            'byte' => trans('document::models.document.byte'),
            'format' => trans('document::models.document.format'),
            'cache' => trans('document::models.document.cache'),
            'folder' => trans('document::models.document.folder')
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
