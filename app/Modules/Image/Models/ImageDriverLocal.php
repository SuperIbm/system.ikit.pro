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

use App\Modules\Image\Contracts\ImageDriver;
use Config;
use File;
use School;

/**
 * Класс драйвер хранения изображений в локальной папке.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageDriverLocal extends ImageDriver
{
    /**
     * Метод получения пути к изображению.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет путь к изображению.
     * @since 1.0
     * @version 1.0
     */
    public function path(int $id, string $format)
    {
        return Config::get('image.store.local.path') . School::getId() . "/" . $id . '.' . $format;
    }

    /**
     * Метод получения физического пути к изображению.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет физический путь к изображению.
     * @since 1.0
     * @version 1.0
     */
    public function pathSource(int $id, string $format)
    {
        return Config::get('image.store.local.pathSource') . $id . '.' . $format;
    }

    /**
     * Метод чтения изображения.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет байт код изображения.
     * @since 1.0
     * @version 1.0
     */
    public function read(int $id, string $format)
    {
        return null;
    }

    /**
     * Метод создания изображения.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     * @param string $path Путь к изображению.
     *
     * @return bool Вернет статус успешности создания изображения.
     * @since 1.0
     * @version 1.0
     */
    public function create(int $id, string $format, string $path)
    {
        return File::copy($path, $this->pathSource($id, $format));
    }

    /**
     * Метод обновления изображения.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     * @param string $path Путь к изображению.
     *
     * @return bool Вернет статус успешности обновления изображения.
     * @since 1.0
     * @version 1.0
     */
    public function update(int $id, string $format, string $path)
    {
        return File::copy($path, $this->pathSource($id, $format));
    }

    /**
     * Метод удаления изображения.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return bool Вернет статус успешности удаления изображения.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(int $id, string $format)
    {
        return File::delete($this->pathSource($id, $format));
    }
}
