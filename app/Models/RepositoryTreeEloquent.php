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

use Util;
use Cache;


/**
 * Трейт репозитария работающий с Eloquent для древовидных структур.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait RepositoryTreeEloquent
{
    use RepositoryEloquent;

    /**
     * Получение дерева страниц.
     *
     * @param array $tags Массив тэгов для кеширования.
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param array $with Массив связанных моделей.
     * @param array $group Массив для группировки.
     * @param array|string $selects Выражения для выборки.
     *
     * @return array|bool Массив данных.
     * @since 1.0
     * @version 1.0
     */
    protected function _tree(array $tags, array $filters = null, bool $active = null, array $sorts = null, array $with = null, array $group = null, array $selects = null)
    {
        $data = $this->_read($tags, null, $filters, $active, $sorts, null, null, $with, $group, $selects, true);

        return $data;
    }

    /**
     * Получение всех родителнй страницы.
     *
     * @param array $tags Тэги для кеширования.
     * @param int $id ID страницы у которой нужно получить всех родителей.
     *
     * @return array Вернет массив страниц.
     * @since 1.0
     * @version 1.0
     */
    protected function _parents(array $tags, int $id): ?array
    {
        $cacheKey = Util::getKey($this->getModel()->getTable(), "tree", "parents", $id);

        $parents = Cache::tags($tags)->remember($cacheKey, $this->getCacheMinutes(), function() use ($id)
        {
            return $this->getModel()->find($id)->ancestors->toArray();
        });

        if(count($parents)) return $parents;
        else return null;
    }

    /**
     * Получение родителя.
     *
     * @param array $tags Тэги для кеширования.
     * @param int $id ID записи у которой нужно получить всех потомков.
     *
     * @return array Вернет запись.
     * @since 1.0
     * @version 1.0
     */
    protected function _parent(array $tags, int $id): ?array
    {
        $cacheKey = Util::getKey($this->getModel()->getTable(), "tree", "parent", $id);

        $parent = Cache::tags($tags)->remember($cacheKey, $this->getCacheMinutes(), function() use ($id)
        {
            return $this->getModel()->find($id)->parent->toArray();
        });

        if(count($parent)) return $parent;
        else return null;
    }

    /**
     * Получение всех детей.
     *
     * @param array $tags Тэги для кеширования.
     * @param int $id ID записи у которой нужно получить всех потомков.
     *
     * @return array Вернет массив записей.
     * @since 1.0
     * @version 1.0
     */
    protected function _children(array $tags, int $id): ?array
    {
        $cacheKey = Util::getKey($this->getModel()->getTable(), "tree", "children", $id);

        $children = Cache::tags($tags)->remember($cacheKey, $this->getCacheMinutes(), function() use ($id)
        {
            return $this->getModel()->find($id)->chidren->toArray();
        });

        if(count($children)) return $children;
        else return null;
    }

    /**
     * Получение всех потомков.
     *
     * @param array $tags Тэги для кеширования.
     * @param int $id ID записи у которой нужно получить всех потомков.
     *
     * @return array Вернет массив записей.
     * @since 1.0
     * @version 1.0
     */
    protected function _descendants(array $tags, int $id): ?array
    {
        $cacheKey = Util::getKey($this->getModel()->getTable(), "tree", "descendants", $id);

        $descendants = Cache::tags($tags)->remember($cacheKey, $this->getCacheMinutes(), function() use ($id)
        {
            $item = $this->getModel()->find($id);

            if($item) return $item->descendants->toArray();
            else return null;
        });

        if($descendants && count($descendants)) return $descendants;
        else return null;
    }

    /**
     * Получение всех предков.
     *
     * @param array $tags Тэги для кеширования.
     * @param int $id ID записи у которой нужно получить всех потомков.
     *
     * @return array Вернет массив записей.
     * @since 1.0
     * @version 1.0
     */
    protected function _ancestors(array $tags, int $id): ?array
    {
        $cacheKey = Util::getKey($this->getModel()->getTable(), "tree", "ancestors", $id);

        $ancestors = Cache::tags($tags)->remember($cacheKey, $this->getCacheMinutes(), function() use ($id)
        {
            $item = $this->getModel()->find($id);

            if($item) return $item->ancestors->toArray();
            else return null;
        });

        if($ancestors && count($ancestors)) return $ancestors;
        else return null;
    }

    /**
     * Поднятие узла.
     *
     * @param array $tags Тэги для кеширования.
     * @param int $id ID страницы у которой нужно получить всех потомков.
     * @param int $amount На какое количество поднять узел.
     * @param string $scopeName Название пространства узла в рамках которого нужно произвести изменение.
     * @param mixed $scopeId Значение пространства узла в рамках которого нужно произвести изменение.
     *
     * @return bool Вернет успешность операци.
     * @since 1.0
     * @version 1.0
     */
    protected function _up(array $tags, int $id, int $amount = 1, $scopeName = null, $scopeId = null): bool
    {
        $model = $this->getModel();

        if($scopeName && $scopeId) $model = $model->where($scopeName, $scopeId);

        $model = $model->find($id);

        if($model)
        {
            $model->up($amount);
            Cache::tags($tags)->flush();
            return true;
        }
        else
        {
            $this->addError("base", trans('modules.repositoryTreeEloquent.node_not_exist'));
            return false;
        }
    }

    /**
     * Опускание узла.
     *
     * @param array $tags Тэги для кеширования.
     * @param int $id ID страницы у которой нужно получить всех потомков.
     * @param int $amount На какое количество опустить узел.
     * @param string $scopeName Название пространства узла в рамках которого нужно произвести изменение.
     * @param mixed $scopeId Значение пространства узла в рамках которого нужно произвести изменение.
     *
     * @return bool Вернет успешность операци.
     * @since 1.0
     * @version 1.0
     */
    protected function _down(array $tags, int $id, int $amount = 1, $scopeName = null, $scopeId = null): bool
    {
        $model = $this->getModel();

        if($scopeName && $scopeId) $model = $model->where($scopeName, $scopeId);

        $model = $model->find($id);

        if($model)
        {
            $model->down($amount);
            Cache::tags($tags)->flush();
            return true;
        }
        else
        {
            $this->addError("base", trans('modules.repositoryTreeEloquent.node_not_exist'));
            return false;
        }
    }

    /**
     * Ремонтирование дерева.
     *
     * @return bool Вернет успешность операци.
     * @since 1.0
     * @version 1.0
     */
    protected function _fix()
    {
        $model = $this->getModel();

        $model->fixTree();

        return true;
    }
}
