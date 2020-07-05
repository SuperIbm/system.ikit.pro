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
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет путь к изображению.
     * @since 1.0
     * @version 1.0
     */
    abstract public function path(int $id, string $format);

    /**
     * Абстрактный метод получения физического пути к изображению.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет физический путь к изображению.
     * @since 1.0
     * @version 1.0
     */
    abstract public function pathSource(int $id, string $format);

    /**
     * Абстрактный метод чтения изображения.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return string Вернет байт код изображения.
     * @since 1.0
     * @version 1.0
     */
    abstract public function read(int $id, string $format);

    /**
     * Абстрактный метод создания изображения.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     * @param string $path Путь к изображению.
     *
     * @return bool Вернет статус успешности создания изображения.
     * @since 1.0
     * @version 1.0
     */
    abstract public function create(int $id, string $format, string $path);

    /**
     * Абстрактный метод обновления изображения.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     * @param string $path Путь к изображению.
     *
     * @return bool Вернет статус успешности обновления изображения.
     * @since 1.0
     * @version 1.0
     */
    abstract public function update(int $id, string $format, string $path);

    /**
     * Абстрактный метод удаления изображения.
     *
     * @param int $id Индификатор изображения.
     * @param string $format Формат изображения.
     *
     * @return bool Вернет статус успешности удаления изображения.
     * @since 1.0
     * @version 1.0
     */
    abstract public function destroy(int $id, string $format);
}
