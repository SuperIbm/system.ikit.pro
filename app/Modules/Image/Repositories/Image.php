<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Repositories;

use File;
use App\Models\Repository;

/**
 * Абстрактный класс построения репозитария.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Image extends Repository
{
    /**
     * Полученные раннее изображения.
     * Будем хранить данные полученных ранее изображений, чтобы снизить нагрузку на систему.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    private static $_images = [];

    /**
     * Получение изображения по ее ID из базы ранее полученных изображений.
     *
     * @param int $id ID изображения.
     *
     * @return array|bool Массив данных страницы.
     * @since 1.0
     * @version 1.0
     */
    protected static function _getById($id)
    {
        if(isset(self::$_images[$id])) return self::$_images[$id];
        else return false;
    }


    /**
     * Установка данных изображения по ее ID в базу ранее полученных изображений.
     *
     * @param int $id ID изображения.
     * @param array $image Данные изображения.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    protected static function _setById($id, $image)
    {
        self::$_images[$id] = $image;
    }


    /**
     * Получение всех записей.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract public function all();


    /**
     * Создание.
     *
     * @param string $path Путь к файлу.
     *
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract public function create($path);


    /**
     * Обновление.
     *
     * @param int $id Id записи для обновления.
     * @param string $path Путь к файлу.
     *
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract public function update($id, $path);


    /**
     * Обновление байт кода картинки.
     *
     * @param int $id Id записи для обновления.
     * @param string $byte Байт код картинки.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    abstract public function updateByte($id, $byte);


    /**
     * Удаление.
     *
     * @param int|array $id Id записи для удаления.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    abstract public function destroy($id);


    /**
     * Создание копии изображения.
     * Коппия создается во временной папке с псевдослучайным названием.
     *
     * @param string $path Путь к изображению из которого нужно сделать копию.
     *
     * @return string|bool Возвращает путь к копии.
     * @since 1.0
     * @version 1.0
     */
    public function copy($path)
    {
        $pro = @getImageSize($path);

        if($pro)
        {
            $tmpfname = $this->tmp($pro[2]);
            File::copy($path, $tmpfname);

            return $tmpfname;
        }
        else return false;
    }


    /**
     * Производит конвертирования изображения из одного формата в другой.
     *
     * @param string $path Путь к изображению.
     * @param string $formatTo Новый формат для изображения.
     *
     * @return string Возвращает путь к новому изображению.
     * @since 1.0
     * @version 1.0
     */
    public function convertTo($path, $formatTo)
    {
        if($this->isRasterGt($path) == true)
        {
            $tmpfname = $this->tmp($formatTo);
            File::put($tmpfname, File::get($path));
            return $tmpfname;
        }
        else return false;
    }


    /**
     * Проверяет растровое ли изображение, с которым может работать библиотека GD2.
     *
     * @param string $path Путь к изображению.
     *
     * @return bool Возвращает true если изображение растровое.
     * @since 1.0
     * @version 1.0
     */
    public function isRasterGt($path)
    {
        $pro = @getImageSize($path);

        if($pro)
        {
            $format = $pro[2];

            if($format >= 1 && $format <= 3) return true;
            else return false;
        }
        else return false;
    }


    /**
     * Проверка векторное ли изображение.
     *
     * @param string $path Путь к изображению.
     *
     * @return bool Возвращает true если изображение векторное.
     * @since 1.0
     * @version 1.0
     */
    public function isVektor($path)
    {
        $pro = @getImageSize($path);

        if($pro)
        {
            $format = $pro[2];

            if($format == 4 || $format == 13) return true;
            else return false;
        }
        else return false;
    }


    /**
     * Проверка является ли файл изображением.
     *
     * @param string $path Путь к изображению.
     *
     * @return bool Возвращает true если файл изображение.
     * @since 1.0
     * @version 1.0
     */
    public function isImage($path)
    {
        if($this->isRasterGt($path) == true || $this->isVektor($path) == true) return true;
        else return false;
    }


    /**
     * Проверка является ли расширение изображением.
     *
     * @param string $extension Расширение без точки.
     *
     * @return bool Возвращает true если расширение относиться к изображению.
     * @since 1.0
     * @version 1.0
     */
    public function isImageByExtension($extension)
    {
        if($this->isRastorGtByExtension($extension) || $this->isVektorByExtension($extension)) return true;
        else return false;
    }


    /**
     * Проверка является ли расширение растровым.
     *
     * @param string $extension Расширение без точки.
     *
     * @return bool Возвращает true если расширение растровое.
     * @since 1.0
     * @version 1.0
     */
    public function isRastorGtByExtension($extension)
    {
        if(in_array($extension, array("jpg", "jpeg", "gif", "png"))) return true;
        else return false;
    }


    /**
     * Проверка является ли расширение векторным.
     *
     * @param string $extension Расширение без точки.
     *
     * @return bool Возвращает true если расширение векторное.
     * @since 1.0
     * @version 1.0
     */
    public function isVektorByExtension($extension)
    {
        if(in_array($extension, array("swf", "flw"))) return true;
        else return false;
    }


    /**
     * Переводит  нумерованный формат в текстовый формат.
     *
     * @param int $format Нумерованный формат.
     *
     * @return string Текстовый формат.
     * @since 1.0
     * @version 1.0
     */
    public function getFormatText($format)
    {
        switch($format)
        {
            case 1:
                return "gif";
            case 2:
                return "jpg";
            case 3:
                return "png";
            case 4:
                return "swf";
            case 5:
                return "psd";
            case 6:
                return "bmp";
            case 7:
                return "tiff";
            case 8:
                return "tiff";
            case 9:
                return "jpc";
            case 10:
                return "jp2";
            case 11:
                return "jpx";
            case 13:
                return "swf";
        }

        return false;
    }

    /**
     * Получение пути к файлу для временного изображения.
     *
     * @param mixed $format Формат изображения в нумерованном виде или текстовом.
     *
     * @return string Путь к временному изображению.
     * @since 1.0
     * @version 1.0
     */
    public function tmp($format)
    {
        $format = is_numeric($format) ? $this->getFormatText($format) : $format;
        return storage_path('app/tmp/img_' . time() . mt_rand(1, 100000) . '.' . $format);
    }
}