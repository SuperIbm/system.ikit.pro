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
use Path;
use Config;
use Storage;


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
    protected static $_login;

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
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет путь к документу.
     * @since 1.0
     * @version 1.0
     */
    public function path($id, $format)
    {
        return 'doc/read/' . $id . '.' . $format;
    }


    /**
     * Метод получения физического пути к документу.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет физический путь к документа.
     * @since 1.0
     * @version 1.0
     */
    public function pathSource($id, $format)
    {
        return Config::get("app.url") . $this->path($id, $format);
    }


    /**
     * Метод чтения документа.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return string Вернет байт код документа.
     * @since 1.0
     * @version 1.0
     */
    public function read($id, $format)
    {
        if(self::$_connection && self::$_login)
        {
            $tmpfname = storage_path('app/tmp/' . $id . '.' . $format);

            if(!Storage::disk('tmp')->exists($id . '.' . $format))
            {
                ftp_get(self::$_connection, $tmpfname, Config::get('document.store.ftp.path') . $id . '.' . $format, FTP_BINARY);
            }

            return Storage::disk('tmp')->get($id . '.' . $format);
        }

        return false;
    }


    /**
     * Метод создания документа.
     *
     * @param int $id Индификатор документа.
     * @param string $path Путь к документу.
     * @param string $format Формат документа.
     *
     * @return bool Вернет статус успешности создания документа.
     * @since 1.0
     * @version 1.0
     */
    public function create($id, $format, $path)
    {
        if(self::$_connection && self::$_login) return ftp_put(self::$_connection, Config::get('document.store.ftp.path') . $id . "." . $format, $path, FTP_BINARY);
        else return false;
    }


    /**
     * Метод обновления документа.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     * @param string $path Путь к документу.
     *
     * @return bool Вернет статус успешности обновления документа.
     * @since 1.0
     * @version 1.0
     */
    public function update($id, $format, $path)
    {
        if(self::$_connection && self::$_login) return ftp_put(self::$_connection, Config::get('document.store.ftp.path') . $id . "." . $format, $path, FTP_BINARY);
        else return false;
    }


    /**
     * Метод удаления документа.
     *
     * @param int $id Индификатор документа.
     * @param string $format Формат документа.
     *
     * @return bool Вернет статус успешности удаления документа.
     * @since 1.0
     * @version 1.0
     */
    public function destroy($id, $format)
    {
        if(self::$_connection && self::$_login)
        {
            return ftp_delete(self::$_connection, Config::get('document.store.ftp.path') . $id . '.' . $format);
        }

        return false;
    }
}