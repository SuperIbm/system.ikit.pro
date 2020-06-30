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

use DB;
use Util;
use Cache;
use Eloquent;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneOrMany;
use Illuminate\Database\Eloquent\Builder;

/**
 * Трейт репозитария работающий с Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait RepositoryEloquent
{
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
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    protected function _get(array $tags, int $id = null, bool $active = null, array $filters = null, array $with = null, array $selects = null)
    {
        $filters = !$filters ? [] : $filters;

        if($id)
        {
            $filters[] = [
                'table' => $this->getModel()->getTable(),
                'property' => $this->getModel()->getKeyName(),
                'value' => $id
            ];
        }

        $values = $this->_read($tags, false, $filters, $active, null, null, null, $with, null, $selects);

        if($values) return $values[0];
        else return null;
    }

    /**
     * Метод построения запроса на основе параметров фильтра.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Построитль запроса.
     * @param array $filters Массив параметров фильтра.
     *
     * @return \Illuminate\Database\Eloquent\Builder Вернет построитель запроса.
     * @since 1.0
     * @version 1.0
     */
    protected static function _queryFilters(Builder $query, array $filters): Builder
    {
        $query->where(function($query) use ($filters) {
            for($i = 0; $i < count($filters); $i++)
            {
                if(Util::isAssoc($filters[$i])) self::_queryFilter($query, $filters[$i]);
                else self::_queryFilters($query, $filters[$i]);
            }
        });

        return $query;
    }

    /**
     * Метод построения запроса на основе параметра фильтра.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query Построитль запроса.
     * @param array $filter Параметры поиска.
     *
     * @return \Illuminate\Database\Eloquent\Builder Вернет построитель запроса.
     * @since 1.0
     * @version 1.0
     */
    protected static function _queryFilter(Builder $query, array $filter): Builder
    {
        if(isset($filter["with"]))
        {
            $query->whereHas($filter["with"], function($query) use ($filter) {
                if(isset($filter['value']))
                {
                    $logic = isset($filter['logic']) ? $filter['logic'] : "AND";

                    if(strtoupper($logic) == "AND") $query->where($filter['property'], !isset($filter['operator']) ? "=" : $filter['operator'], $filter['value']);
                    else $query->orWhere($filter['property'], !isset($filter['operator']) ? "=" : $filter['operator'], $filter['value']);
                }
            });
        }
        else
        {
            $logic = isset($filter['logic']) ? $filter['logic'] : "AND";

            if(strtoupper($logic) == "AND")
            {
                $query->where($filter['property'], !isset($filter['operator']) ? "=" : $filter['operator'], $filter['value']);
            }
            else
            {
                $query->orWhere($filter['property'], !isset($filter['operator']) ? "=" : $filter['operator'], $filter['value']);
            }
        }

        return $query;
    }

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
     * @param array $selects Выражения для выборки.
     * @param bool $toTree Переведет все в дерево.
     *
     * @return array|int Массив данных.
     * @since 1.0
     * @version 1.0
     */
    protected function _read(array $tags, $count = false, array $filters = null, bool $active = null, array $sorts = null, int $offset = null, int $limit = null, array $with = null, array $group = null, array $selects = null, bool $toTree = false)
    {
        $query = $this->newInstance()->newQuery();

        if($selects)
        {
            $queryStrRawSelect = "";

            if(!is_array($selects)) $selects = [$selects];

            for($i = 0; $i < count($selects); $i++)
            {
                if($queryStrRawSelect != "") $queryStrRawSelect .= ", ";

                $queryStrRawSelect .= $selects[$i];
            }

            $query->select(DB::raw($queryStrRawSelect));
        }

        $filtersValues = [];

        if($filters)
        {
            $filtersValues = self::filters($filters, $this->newInstance()->getFillable(), $query->getModel()
                ->getTable());
        }

        if(isset($active))
        {
            if($active == true) $query->active();
            else $query->notActive();
        }

        if($toTree) $query->withDepth();

        if($sorts) $sorts = self::sorts($sorts, $this->newInstance()->getFillable(), $query->getModel()->getTable());
        else if($toTree) $query->defaultOrder();

        if($with)
        {
            for($i = 0; $i < count($with); $i++)
            {
                $names = $with[$i];
                $query->with($names);
                $names = explode(".", $names);

                $relation = $query->getModel();

                for($y = 0; $y < count($names); $y++)
                {
                    $name = $names[$y];

                    if($y != 0) $relation = $relation->getRelated()->$name();
                    else $relation = $relation->$name();

                    $modelRelated = $relation->getRelated();
                    $fillables = $modelRelated->getFillable();

                    if($filters) $fils = self::filters($filters, $fillables, $modelRelated->getTable());

                    if($sorts) $sorts = self::sorts($sorts, $fillables, $modelRelated->getTable());

                    if($filters && $fils)
                    {
                        for($z = 0; $z < count($fils); $z++)
                        {
                            $fils[$z]["with"] = $with[$i];
                        }

                        $filtersValues = array_merge($filtersValues, $fils);
                    }

                    if($sorts)
                    {
                        $related = $relation->getRelated();
                        $tableForeign = $related->getTable();
                        $kyeOwner = null;
                        $keyForeign = null;

                        if($relation instanceof HasOneOrMany)
                        {
                            $kyeOwner = $relation->getQualifiedParentKeyName();
                            $keyForeign = $relation->getForeignKeyName();
                            $query->leftJoin($tableForeign, $kyeOwner, $tableForeign . "." . $keyForeign)
                                ->groupBy($kyeOwner);
                        }
                        else if($relation instanceof BelongsTo)
                        {
                            $kyeOwner = $relation->getForeignKeyName();
                            $keyForeign = $tableForeign . '.' . $relation->getOwnerKeyName();
                            $query->leftJoin($tableForeign, $kyeOwner, $keyForeign)->groupBy($query->getModel()
                                    ->getTable() . "." . $query->getModel()->getKeyName());
                        }

                        $query->select(DB::raw($query->getModel()->getTable() . ".*"));
                    }
                }
            }
        }

        if(count($filtersValues)) $this->_queryFilters($query, $filtersValues);

        if($sorts)
        {
            for($i = 0; $i < count($sorts); $i++)
            {
                $query->orderBy($sorts[$i]['property'], $sorts[$i]['direction']);
            }
        }

        if($offset) $query->offset($offset);
        if($limit) $query->limit($limit);
        if($group) $query->groupBy($group);

        $countString = $count == true ? 'count' : 'rows';
        $cacheKey = Util::getKey($query->getConnection()
            ->getName(), $query->toSql(), $query->getBindings(), $countString, $with, $toTree);

        $data = Cache::tags($tags)
            ->remember($cacheKey, $this->getCacheMinutes(), function() use ($query, $count, $toTree) {
                if($count) return $query->count();
                else if($toTree) return $query->get()->toTree()->toArray();
                else return $query->get()->toArray();
            });

        if($data) return $data;
        else if($count) return 0;
        else return null;
    }

    /**
     * Создание.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param array $data Данные для добавления.
     *
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    protected function _create(array $tags, array $data)
    {
        $model = $this->newInstance();
        unset($data[$model->getKeyName()]);

        foreach($data as $k => $v)
        {
            if($data[$k] === "") unset($data[$k]);
        }

        $model = $model->create($data);

        if($model->hasError())
        {
            $this->setErrors($model->getErrors());
            return false;
        }
        else Cache::tags($tags)->flush();

        return $model->getKey();
    }

    /**
     * Обновление.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     *
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    protected function _update(array $tags, int $id, array $data)
    {
        $model = $this->newInstance()->find($id);

        if($model)
        {
            $status = $model->update($data);

            if($model->hasError() == true || $status == false)
            {
                $this->setErrors($model->getErrors());
                return false;
            }
            else Cache::tags($tags)->flush();

            return $id;
        }
        else
        {
            $this->addError("base", "The record doesn't exist");

            return false;
        }
    }

    /**
     * Удаление.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param int|array $id Id записи для удаления.
     * @param bool $force Просим удалить записи полностью.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    protected function _destroy(array $tags, $id, $force = false): bool
    {
        $model = $this->newInstance();

        if($force)
        {
            $models = $model->whereIn("id", is_array($id) ? $id : [$id])->get();

            if($models)
            {
                foreach($models as $model)
                {
                    $model->forceDelete();
                }
            }

            $status = true;
        }
        else $status = $model->destroy($id);

        if(!$status && $model->hasError()) $this->setErrors($model->getErrors());
        else Cache::tags($tags)->flush();

        return $status;
    }

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
    public function newInstance(array $data = array(), $exists = false): Eloquent
    {
        $model = $this->getModel()->newInstance($data, $exists);

        if($exists && isset($data[$model->getKeyName()])) $model->{$model->getKeyName()} = $data[$model->getKeyName()];

        return $model;
    }
}
