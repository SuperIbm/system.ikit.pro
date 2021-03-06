<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Repositories;

use App\Models\Repository;
use File;

/**
 * Абстрактный класс построения репозитария.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Document extends Repository
{
    /**
     * Полученные ранние документы.
     * Будем хранить данные полученных ранее документов, чтобы снизить нагрузку на систему.
     *
     * @var array
     * @version 1.0
     * @since 1.0
     */
    private static array $_documents = [];

    /**
     * Папка для хранения.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private string $_folder;

    /**
     * Получение документа по его ID из базы ранее полученных документов.
     *
     * @param int $id ID документа.
     *
     * @return array|bool Массив данных документа.
     * @since 1.0
     * @version 1.0
     */
    protected static function _getById(int $id)
    {
        if(isset(self::$_documents[$id])) return self::$_documents[$id];
        else return false;
    }

    /**
     * Установка данных документа по его ID в базу ранее полученных документов.
     *
     * @param int $id ID документа.
     * @param array $document Данные документа.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    protected static function _setById(int $id, array $document): void
    {
        self::$_documents[$id] = $document;
    }

    /**
     * Получение всех записей.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract public function all(): ?array;

    /**
     * Создание.
     *
     * @param string $path Путь к файлу.
     *
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract public function create(string $path);

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
    abstract public function update(int $id, string $path);

    /**
     * Обновление байт кода документа.
     *
     * @param int $id Id записи для обновления.
     * @param string $byte Байт код документа.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    abstract public function updateByte(int $id, string $byte): bool;

    /**
     * Удаление.
     *
     * @param int|array $id Id записи для удаления.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    abstract public function destroy($id): bool;

    /**
     * Проверяет вес документа в байтах.
     *
     * @param int $weight Вес документа в байтах.
     * @param int $weightMin Минимальный вес в байтах.
     * @param int $weightMax Максимальный вес в байтах.
     *
     * @return bool Возвращает true если вес соответствует заданным параметрам.
     * @since 1.0
     * @version 1.0
     */
    public function isWeight(int $weight, int $weightMin = null, int $weightMax = null): bool
    {
        if($weightMin != null && $weightMin > $weight) return false;
        if($weightMax != null && $weightMax < $weight) return false;

        return true;
    }

    /**
     * Проверка веса документа указывая файл.
     *
     * @param string $path Путь к документу.
     * @param int $weightMin Минимальный вес в байтах.
     * @param int $weightMax Максимальный вес в байтах.
     *
     * @return bool Возвращает true если вес соответствует заданным параметрам.
     * @since 1.0
     * @version 1.0
     */
    public function isWeightByFile(string $path, int $weightMin = null, int $weightMax = null): bool
    {
        $weight = filesize($path);
        return $this->isWeight($weight, $weightMin, $weightMax);
    }

    /**
     * Создание копии документа.
     * Коппия создается во временной папке с псевдослучайным названием.
     *
     * @param string $path Путь к документу из которого нужно сделать копию.
     *
     * @return string Возвращает путь к копии.
     * @since 1.0
     * @version 1.0
     */
    public function copy(string $path): string
    {
        $tmpfname = $this->tmp(pathinfo($path)["extension"]);
        File::copy($path, $tmpfname);

        return $tmpfname;
    }

    /**
     * Получение пути к файлу для временного изображения.
     *
     * @param mixed $format Формат изображения в текстовом виде.
     *
     * @return string Путь к временному изображению.
     * @since 1.0
     * @version 1.0
     */
    public function tmp(string $format): string
    {
        return storage_path('app/tmp/doc_' . time() . mt_rand(1, 100000) . '.' . $format);
    }

    /**
     * Установка папки хранения.
     *
     * @param string $folder Название папки.
     *
     * @return $this Вернет текущий объект.
     * @since 1.0
     * @version 1.0
     */
    public function setFolder(string $folder): Document
    {
        $this->_folder = $folder;

        return $this;
    }

    /**
     * Получение папки хранения.
     *
     * @return string Вернет название папки.
     * @since 1.0
     * @version 1.0
     */
    public function getFolder(): string
    {
        return $this->_folder;
    }
}
