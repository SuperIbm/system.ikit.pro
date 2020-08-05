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
use Storage;
use School;

/**
 * Класс драйвер хранения документов с использованием FTP протокола.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentDriverFtp extends DocumentDriver
{
    /**
     * Содержит ссылку на подключения по FTP.
     *
     * @var resource
     * @since 1.0
     * @version 1.0
     */
    protected static $_connection;

    /**
     * Содержит ссылку на аунтификацию соединения через FTP.
     *
     * @var resource
     * @since 1.0
     * @version 1.0
     */
    protected static string $_login;

    /**
     * Конструктор.
     * Производим подключение к серверу.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct()
    {
        if(!self::$_connection)
        {
            self::$_connection = ftp_connect(Config::get('document.store.ftp.server'));

            if(self::$_connection)
            {
                self::$_login = ftp_login(self::$_connection, Config::get('document.store.ftp.login'), Config::get('document.store.ftp.password'));
                ftp_pasv(self::$_connection, true);
            }
        }
    }

    /**
     * Диструктор.
     * Производим отключение от сервера.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __destruct()
    {
        ftp_close(self::$_connection);
    }

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
        return 'doc/read/' . School::getId() . "/" . $folder . "/" . $id . '.' . $format;
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
        return Config::get("app.url") . $this->path($folder, $id, $format);
    }

    /**
     * Метод чтения документа.
     *
     * @param string $folder Папка.
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет байт код документа.
     * @throws
     * @since 1.0
     * @version 1.0
     */
    public function read(string $folder, int $id, string $format)
    {
        if(self::$_connection && self::$_login)
        {
            $tmpfname = storage_path('app/tmp/' . $id . '.' . $format);

            if(!Storage::disk('tmp')->exists($id . '.' . $format))
            {
                ftp_get(self::$_connection, $tmpfname, Config::get('document.store.ftp.path') . "/" . School::getId() . "/" . $folder . "/" . $id . '.' . $format, FTP_BINARY);
            }

            return Storage::disk('tmp')->get($id . '.' . $format);
        }

        return false;
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
        if(self::$_connection && self::$_login) return ftp_put(self::$_connection, Config::get('document.store.ftp.path') . "/" . School::getId() . "/" . $folder . "/" . $id . "." . $format, $path, FTP_BINARY);
        else return false;
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
        if(self::$_connection && self::$_login) return ftp_put(self::$_connection, Config::get('document.store.ftp.path') . "/" . School::getId() . "/" . $folder . "/" . $id . "." . $format, $path, FTP_BINARY);
        else return false;
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
        if(self::$_connection && self::$_login)
        {
            return ftp_delete(self::$_connection, Config::get('document.store.ftp.path') . "/" . School::getId() . "/" . $folder . "/" . $id . '.' . $format);
        }

        return false;
    }
}
