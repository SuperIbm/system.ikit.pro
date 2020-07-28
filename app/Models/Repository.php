<?php
/**
 * Ядро базовых классов.
 * Этот пакет содержит ядро базовых классов для работы с основными компонентами и возможностями системы.
 *
 * @package App.Models
 * @since 1.0
 * @version 1.0
 */

namespace App\Models;

use Illuminate\Database\Query\Expression;
use Eloquent;
use Util;

/**
 * Абстрактный класс репозитария, для построения собственных репозитариев.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
abstract class Repository
{
    use Error;

    /**
     * Модель данного репозитацрия.
     *
     * @var \Eloquent
     * @version 1.0
     * @since 1.0
     */
    private $_model;

    /**
     * Количество минут на сколько должен сохранятся кешь.
     *
     * @var int
     * @version 1.0
     * @since 1.0
     */
    protected $_cacheMinutes = 60;

    /**
     * Конструктор.
     *
     * @param \Eloquent $model Модель данного репозитария.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Eloquent $model)
    {
        $this->_setModel($model);
    }

    /**
     * Получение модели этого репозитария.
     *
     * @return \Eloquent Модель данного репозитария.
     * @since 1.0
     * @version 1.0
     */
    public function getModel(): Eloquent
    {
        return $this->_model;
    }

    /**
     * Уствнока модели этого репозитария.
     *
     * @param \Eloquent $model Модель данного репозитария.
     *
     * @return \App\Models\Repository
     * @since 1.0
     * @version 1.0
     */
    protected function _setModel(Eloquent $model): Repository
    {
        $this->_model = $model;

        return $this;
    }

    /**
     * Получение количество минут на сколько должен сохранятся кешь.
     *
     * @return int Количество минут.
     * @since 1.0
     * @version 1.0
     */
    public function getCacheMinutes(): int
    {
        return $this->_cacheMinutes;
    }

    /**
     * Установка количества минут на сколько должен сохранятся кешь.
     *
     * @param int $minutes Количество минут.
     *
     * @return \App\Models\Repository
     * @since 1.0
     * @version 1.0
     */
    public function setCacheMinutes(int $minutes): Repository
    {
        $this->_cacheMinutes = $minutes;

        return $this;
    }

    /**
     * Перевод ключ значение к формату репозитария для сортировки данных.
     *
     * @param array $sorts Массив значений для сортировки.
     * @param array $allows Массив допустимых колонок, которые могут сортироваться в данной таблице.
     * @param string $table Название таблицы для сортировки.
     *
     * @return array Преобразованный массив сортировки для репозитариев.
     * @since 1.0
     * @version 1.0
     */
    public static function sorts(array $sorts, array $allows, string $table): array
    {
        for($i = 0; $i < count($sorts); $i++)
        {
            if(in_array($sorts[$i]['property'], $allows) || @$sorts[$i]['table'] == $table)
            {
                if(($sorts[$i]['property'] instanceof Expression) == false) $sorts[$i]['property'] = $table . '.' . $sorts[$i]['property'];
            }
        }

        return $sorts;
    }

    /**
     * Перевод ключ значение к формату репозитария для филтрации данных.
     *
     * @param array $filter Массив значений для фильтрации.
     * @param array $allows Массив допустимых параметров.
     * @param string $table Название таблицы для колонок фильтрации.
     *
     * @return array|boolean Преобразованный массив фильтрации для репозитариев.
     * @since 1.0
     * @version 1.0
     */
    protected static function _filters(array $filter, array $allows = null, string $table = null)
    {
        if(isset($filter['operator']))
        {
            if($filter['operator'] == "==") $filter["operator"] = "=";
            if($filter['operator'] == "lt") $filter["operator"] = ">";
            if($filter['operator'] == "gt") $filter["operator"] = "<";
            if($filter['operator'] == "eq") $filter["operator"] = "=";
            if($filter['operator'] == "in") $filter["operator"] = "=";
            if(strtolower($filter['operator']) == "like" && $filter["value"]) $filter["value"] = "%" . $filter["value"] . "%";
        }

        if($allows)
        {
            $property = explode(".", $filter['property']);
            $nameTable = count($property) - 2;
            $nameColumn = count($property) - 1;

            if(isset($property[$nameTable]) && isset($property[$nameColumn]))
            {
                if($property[$nameTable] != $table) return false;
            }

            if((!isset($filter['table']) && in_array($filter['property'], $allows)) || (isset($filter['table']) && @$filter['table'] == $table))
            {
                if(!$filter['property'] instanceof Expression) $filter['property'] = $table . '.' . $filter['property'];
            }
            else return false;
        }

        return $filter;
    }

    /**
     * Перевод ключ значение к формату репозитария для фильтрации данных.
     *
     * @param array $filters Массив значений для фильтрации.
     * @param array $allows Массив допустимых параметров.
     * @param string $table Название таблицы для колонок фильтрации.
     *
     * @return array Преобразованный массив фильтрации для репозитариев.
     * @since 1.0
     * @version 1.0
     */
    public static function filters(array $filters, array $allows = null, string $table = null): array
    {
        $filtersNew = [];

        for($i = 0; $i < count($filters); $i++)
        {
            if(Util::isAssoc($filters[$i]))
            {
                $filter = self::_filters($filters[$i], $allows, $table);

                if($filter) $filtersNew[] = $filter;
            }
            else
            {
                $filtersInside = self::filters($filters[$i], $allows, $table);

                if(count($filtersInside)) $filtersNew[] = $filtersInside;
            }
        }

        return $filtersNew;
    }

    /**
     * Получить по первичному ключу.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $filters Фильтрация данных.
     * @param array $with Массив связанных моделей.
     * @param array|string $selects Выражения для выборки.
     *
     * @return array|bool Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _get(array $tags, int $id = null, bool $active = null, array $filters = null, array $with = null, array $selects = null);

    /**
     * Чтение данных.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param bool $count Вернуть только количество записей.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param array $with Массив связанных моделей.
     * @param array $group Массив для группировки.
     * @param array|string $selects Выражения для выборки.
     * @param bool $toTree Переведет все в дерево.
     *
     * @return array|bool Массив данных.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _read(array $tags, $count = false, array $filters = null, bool $active = null, array $sorts = null, int $offset = null, int $limit = null, array $with = null, array $group = null, array $selects = null, bool $toTree = false);

    /**
     * Создание.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param array $data Данные для добавления.
     *
     * @return int|bool Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _create(array $tags, array $data);

    /**
     * Обновление.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     *
     * @return int|bool Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _update(array $tags, int $id, array $data);

    /**
     * Удаление.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param int|array $id Id записи для удаления.
     * @param array $filters Фильтрация данных.
     * @param bool $force Просим удалить записи полностью.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    abstract protected function _destroy(array $tags, $id, array $filters, bool $force = false): bool;

    /**
     * Получение нового экземпляра модели.
     *
     * @param array $data Данные этой модели.
     * @param bool $exists Определяет существует ли эта запись или нет.
     *
     * @return \Eloquent Объект модели данного репозитария.
     * @since 1.0
     * @version 1.0
     */
    abstract public function newInstance(array $data = array(), bool $exists = false): Eloquent;
}
