<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Contracts;

use App\Models\Error;

/**
 * Абстрактный класс позволяющий проектировать собственные классы для хранения документов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class DocumentDriver
{
    use Error;

    /**
     * Абстрактный метод получения пути к документу.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет путь к документу.
     * @since 1.0
     * @version 1.0
     */
    abstract public function path(string $folder, int $id, string $format);

    /**
     * Абстрактный метод получения физического пути к документу.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет физический путь к документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function pathSource(string $folder, int $id, string $format);

    /**
     * Абстрактный метод чтения документа.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет байт код документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function read(string $folder, int $id, string $format);

    /**
     * Абстрактный метод создания документа.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     * @param string $path Путь к документу.
     *
     * @return bool Вернет статус успешности создания документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function create(string $folder, int $id, string $format, string $path): bool;

    /**
     * Абстрактный метод обновления документа.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     * @param string $path Путь к документу.
     *
     * @return bool Вернет статус успешности обновления документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function update(string $folder, int $id, string $format, string $path): bool;

    /**
     * Абстрактный метод удаления документа.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return bool Вернет статус успешности удаления документа.
     * @since 1.0
     * @version 1.0
     */
    abstract public function destroy(string $folder, int $id, string $format): bool;
}
