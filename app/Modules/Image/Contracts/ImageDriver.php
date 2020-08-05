<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Contracts;

use App\Models\Error;

/**
 * Абстрактный класс позволяющий проектировать собственные классы для хранения изображений.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class ImageDriver
{
    use Error;

    /**
     * Абстрактный метод получения пути к изображению.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет путь к изображению.
     * @since 1.0
     * @version 1.0
     */
    abstract public function path(string $folder, int $id, string $format): ?string;

    /**
     * Абстрактный метод получения физического пути к изображению.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет физический путь к изображению.
     * @since 1.0
     * @version 1.0
     */
    abstract public function pathSource(string $folder, int $id, string $format): ?string;

    /**
     * Абстрактный метод чтения изображения.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет байт код изображения.
     * @since 1.0
     * @version 1.0
     */
    abstract public function read(string $folder, int $id, string $format);

    /**
     * Абстрактный метод создания изображения.
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
    abstract public function create(string $folder, int $id, string $format, string $path): bool;

    /**
     * Абстрактный метод обновления изображения.
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
    abstract public function update(string $folder, int $id, string $format, string $path): bool;

    /**
     * Абстрактный метод удаления изображения.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return bool Вернет статус успешности удаления изображения.
     * @since 1.0
     * @version 1.0
     */
    abstract public function destroy(string $folder, int $id, string $format): bool;
}
