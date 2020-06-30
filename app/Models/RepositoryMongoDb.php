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


/**
 * Трейт репозитария работающий с MongoDb.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait RepositoryMongoDb
{
    use RepositoryEloquent;

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

        $pages = $this->_read($tags, false, $filters, $active, null, null ,null, $with, null, $selects);

        if($pages) return $pages[0];
        else return null;
    }
}
