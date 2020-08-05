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

use App\Modules\Document\Contracts\DocumentDriver;
use Config;
use File;
use School;

/**
 * Класс драйвер хранения документов в локальной папке.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentDriverLocal extends DocumentDriver
{
    /**
     * Метод получения пути к документу.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет путь к документу.
     * @since 1.0
     * @version 1.0
     */
    public function path(string $folder, int $id, string $format): ?string
    {
        return Config::get('document.store.local.path') . School::getId() . "/" . $folder . "/" . $id . '.' . $format;
    }

    /**
     * Метод получения физического пути к документу.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет физический путь к документа.
     * @since 1.0
     * @version 1.0
     */
    public function pathSource(string $folder, int $id, string $format): ?string
    {
        return Config::get('document.store.local.pathSource') . School::getId() . "/" . $folder . "/" . $id . '.' . $format;
    }

    /**
     * Метод чтения документа.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет байт код документа.
     * @since 1.0
     * @version 1.0
     */
    public function read(string $folder, int $id, string $format)
    {
        return null;
    }

    /**
     * Метод создания документа.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $path Путь к документу.
     * @param string $format Формат документа.
     *
     * @return bool Вернет статус успешности создания документа.
     * @since 1.0
     * @version 1.0
     */
    public function create(string $folder, int $id, string $format, string $path): bool
    {
        return File::copy($path, $this->pathSource($folder, $id, $format));
    }

    /**
     * Метод обновления документа.
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
    public function update(string $folder, int $id, string $format, string $path): bool
    {
        return File::copy($path, $this->pathSource($folder, $id, $format));
    }

    /**
     * Метод удаления документа.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return bool Вернет статус успешности удаления документа.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(string $folder, int $id, string $format): bool
    {
        return File::delete($this->pathSource($folder, $id, $format));
    }
}
