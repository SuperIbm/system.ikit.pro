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
use \CURLFile;
use File;
use School;

/**
 * Класс драйвер хранения изображений с использованием HTTP протокола.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageDriverHttp extends ImageDriver
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
    public function path(string $folder, int $id, string $format)
    {
        return Config::get('image.store.http.read') . School::getId() . "/" . $folder . "/" . $id . '.' . $format;
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
    public function pathSource(string $folder, int $id, string $format)
    {
        return $this->path($folder, $id, $format);
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
        return null;
    }

    /**
     * Метод создания изображения.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     * @param string $path Путь к изображению.
     *
     * @return bool Вернет статус успешности создания изображения.
     * @since 1.0
     * @version 1.0
     */
    public function create(string $folder, int $id, string $format, string $path)
    {
        $ch = curl_init();
        $tmp = storage_path('app/tmp/' . basename($path));
        File::copy($path, $tmp);

        $data = [
            'id' => $id,
            'format' => $format,
            'file' => new CURLFile($tmp),
            'folder' => $folder
        ];

        curl_setopt($ch, CURLOPT_URL, Config::get('image.store.http.create'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_exec($ch);
        curl_close($ch);

        return true;
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
    public function update(string $folder, int $id, string $format, string $path)
    {
        $ch = curl_init();
        $tmp = storage_path('app/tmp/' . basename($path));
        File::copy($path, $tmp);

        $data = [
            'id' => $id,
            'format' => $format,
            'file' => new CURLFile($tmp),
            'folder' => $folder
        ];

        curl_setopt($ch, CURLOPT_URL, Config::get('image.store.http.update'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_exec($ch);
        curl_close($ch);

        return true;
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
    public function destroy(string $folder, int $id, string $format)
    {
        $ch = curl_init();

        $data = [
            'id' => $id,
            'format' => $format,
            'folder' => $folder
        ];

        curl_setopt($ch, CURLOPT_URL, Config::get('image.store.http.destroy'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_exec($ch);
        curl_close($ch);

        return true;
    }
}
