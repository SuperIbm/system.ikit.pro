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
use \CURLFile;
use File;
use School;

/**
 * Класс драйвер хранения документов с использованием HTTP протокола.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentDriverHttp extends DocumentDriver
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
        return Config::get('document.store.http.read') . School::getId() . $folder. "/" . "/" . $id . '.' . $format;
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
        return $this->path($folder, $id, $format);
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
        $ch = curl_init();
        $tmp = storage_path('app/tmp/' . basename($path));
        File::copy($path, $tmp);

        $data = [
            'id' => $id,
            'format' => $format,
            'file' => new CURLFile($tmp),
            'folder' => $folder
        ];

        curl_setopt($ch, CURLOPT_URL, Config::get('document.store.http.create'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_exec($ch);
        curl_close($ch);

        return true;
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
        $ch = curl_init();
        $tmp = storage_path('app/tmp/' . basename($path));
        File::copy($path, $tmp);

        $data = [
            'id' => $id,
            'format' => $format,
            'file' => new CURLFile($tmp),
            'folder' => $folder
        ];

        curl_setopt($ch, CURLOPT_URL, Config::get('document.store.http.update'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_exec($ch);
        curl_close($ch);

        return true;
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
        $ch = curl_init();

        $data = [
            'id' => $id,
            'format' => $format,
            'folder' => $folder
        ];

        curl_setopt($ch, CURLOPT_URL, Config::get('document.store.http.destroy'));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_exec($ch);
        curl_close($ch);

        return true;
    }
}
