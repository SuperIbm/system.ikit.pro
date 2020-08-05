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
use Image as ImageRepository;
use Config;
use School;

/**
 * Класс драйвер хранения изображений в базе данных.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageDriverBase extends ImageDriver
{
    /**
     * Метод получения пути к изображению.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет путь к изображению.
     * @since 1.0
     * @version 1.0
     */
    public function path(string $folder, int $id, string $format): ?string
    {
        return 'img/read/' . School::getId() . "/". $folder . "/" . $id . '.' . $format;
    }

    /**
     * Метод получения физического пути к изображению.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет физический путь к изображению.
     * @since 1.0
     * @version 1.0
     */
    public function pathSource(string $folder, int $id, string $format): ?string
    {
        return Config::get("app.url") . $this->path($folder, $id, $format);
    }

    /**
     * Метод чтения изображения.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет байт код изображения.
     * @since 1.0
     * @version 1.0
     */
    public function read(string $folder, int $id, string $format)
    {
        return ImageRepository::getByte(pathinfo($id . '.' . $format, PATHINFO_FILENAME));
    }

    /**
     * Метод создания изображения.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $path Путь к изображению.
     * @param string $format Формат изображения.
     *
     * @return bool Вернет статус успешности создания изображения.
     * @since 1.0
     * @version 1.0
     */
    public function create(string $folder, int $id, string $format, string $path): bool
    {
        $pro = getImageSize($path);
        $imgResource = ImageRepository::getResourceByFormat($pro[2], $path);
        $byte = ImageRepository::getByteByFormat($pro[2], $imgResource);

        return ImageRepository::updateByte($id, $byte);
    }

    /**
     * Метод обновления изображения.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     * @param string $path Путь к изображению.
     *
     * @return bool Вернет статус успешности обновления изображения.
     * @since 1.0
     * @version 1.0
     */
    public function update(string $folder, int $id, string $format, string $path): bool
    {
        $pro = getImageSize($path);
        $imgResource = ImageRepository::getResourceByFormat($pro[2], $path);
        $byte = ImageRepository::getByteByFormat($pro[2], $imgResource);

        return ImageRepository::updateByte($id, $byte);
    }

    /**
     * Метод удаления изображения.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return bool Вернет статус успешности удаления изображения.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(string $folder, int $id, string $format): bool
    {
        return true;
    }
}

