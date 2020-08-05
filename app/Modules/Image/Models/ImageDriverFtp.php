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
use Storage;
use School;

/**
 * Класс драйвер хранения изображений с использованием FTP протокола.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageDriverFtp extends ImageDriver
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
            self::$_connection = ftp_connect(Config::get('image.store.ftp.server'));

            if(self::$_connection)
            {
                self::$_login = ftp_login(self::$_connection, Config::get('image.store.ftp.login'), Config::get('image.store.ftp.password'));
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
        return 'img/read/' . School::getId() . "/" . $folder . "/" . $id . '.' . $format;
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
     * @throws
     * @since 1.0
     * @version 1.0
     */
    public function read(string $folder, int $id, string $format)
    {
        if(self::$_connection && self::$_login)
        {
            $tmpfname = storage_path('app/tmp/' . $id . '.' . $format);

            if(!Storage::disk('tmp')
                ->exists($id . '.' . $format)) ftp_get(self::$_connection, $tmpfname, Config::get('image.store.ftp.path') . School::getId() . "/" . $folder . "/" . $id . '.' . $format, FTP_BINARY);

            return Storage::disk('tmp')->get($id . '.' . $format);
        }

        return false;
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
    public function create(string $folder, int $id, string $format, string $path): bool
    {
        if(self::$_connection && self::$_login) return ftp_put(self::$_connection, Config::get('image.store.ftp.path') . School::getId() . "/" . $folder . "/" . $id . "." . $format, $path, FTP_BINARY);
        else return false;
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
        if(self::$_connection && self::$_login) return ftp_put(self::$_connection, Config::get('image.store.ftp.path') . School::getId() . "/" . $folder . "/" . $id . "." . $format, $path, FTP_BINARY);
        else return false;
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
        if(self::$_connection && self::$_login) return ftp_delete(self::$_connection, Config::get('image.store.ftp.path') . School::getId() . "/" . $folder . "/" . $id . '.' . $format);

        return false;
    }
}
