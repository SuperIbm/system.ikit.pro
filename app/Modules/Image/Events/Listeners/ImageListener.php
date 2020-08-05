<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Events\Listeners;

use Eloquent;
use App;
use Config;

/**
 * Класс обработчик событий для модели изображений.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageListener
{
    /**
     * Обработчик события при добавлении записи.
     *
     * @param \App\Modules\Image\Models\ImageEloquent|\App\Modules\Image\Models\ImageMongoDb $image Модель изображений.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function created(Eloquent $image): bool
    {
        return App::make('image.store.driver')->create($image->folder, $image->id, $image->format, $image->path);
    }

    /**
     * Обработчик события при обновлении записи.
     *
     * @param \App\Modules\Image\Models\ImageEloquent|\App\Modules\Image\Models\ImageMongoDb $image Модель изображений.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function updated(Eloquent $image): bool
    {
        App::make('image.store.driver')->destroy($image->getOriginal()['folder'], $image->getOriginal()['id'], $image->getOriginal()['format']);
        return App::make('image.store.driver')->update($image->folder, $image->id, $image->format, $image->path);
    }

    /**
     * Обработчик события при чтении данных.
     *
     * @param \App\Modules\Image\Models\ImageEloquent|\App\Modules\Image\Models\ImageMongoDb $image Модель изображений.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function readed(Eloquent $image): bool
    {
        $image->path = Config::get("app.url").App::make('image.store.driver')->path($image->folder, $image->id, $image->format);
        $image->pathCache = $image->path;
        $image->byte = App::make('image.store.driver')->read($image->folder, $image->id, $image->format);

        if($image->cache) $image->path .= "?" . $image->cache;

        $image->pathSource = App::make('image.store.driver')->pathSource($image->folder, $image->id, $image->format);

        return true;
    }

    /**
     * Обработчик события при удалении записи.
     *
     * @param \App\Modules\Image\Models\ImageEloquent|\App\Modules\Image\Models\ImageMongoDb $image Модель изображений.
     *
     * @return bool Вернет успешность выполнения операции.
     * @version 1.0
     * @since 1.0
     */
    public function deleted(Eloquent $image): bool
    {
        if(!Config::get("image.store.softDeletes")) return App::make('image.store.driver')->destroy($image->folder, $image->id, $image->format);
        else return true;
    }
}
