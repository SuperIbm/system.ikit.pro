<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Events\Listeners;

use App;
use Config;

/**
 * Класс обработчик событий для модели документов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentListener
{
    /**
     * Обработчик события при добавлении записи.
     *
     * @param \App\Modules\Document\Models\DocumentEloquent|App\Modules\Document\Models\DocumentMongoDb $document Модель документов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function created($document)
    {
        return App::make('document.driver')->create($document->id_document, $document->format, $document->path);
    }


    /**
     * Обработчик события при обновлении записи.
     *
     * @param \App\Modules\Document\Models\DocumentEloquent|App\Modules\Document\Models\DocumentMongoDb $document Модель документов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function updated($document)
    {
        App::make('document.driver')->destroy($document->getOriginal()['id_document'], $document->getOriginal()['format']);
        return App::make('document.driver')->update($document->id_document, $document->format, $document->path);
    }


    /**
     * Обработчик события при чтении данных.
     *
     * @param \App\Modules\Document\Models\DocumentEloquent|App\Modules\Document\Models\DocumentMongoDb $document Модель документов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function readed($document)
    {
        $document->path = App::make('document.driver')->path($document->id, $document->format);
        $document->pathCache = $document->path;
        $document->byte = App::make('document.driver')->read($document->id, $document->format);

        if($document->cache) $document->path .= "?" . $document->cache;

        $document->pathSource = App::make('document.driver')->pathSource($document->id, $document->format);

        return true;
    }


    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\Document\Models\DocumentEloquent|App\Modules\Document\Models\DocumentMongoDb $document Модель документов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleted($document)
    {
        if(!Config::get("document.softDeletes")) return App::make('document.driver')->destroy($document->id_document, $document->format);
        else return true;
    }
}