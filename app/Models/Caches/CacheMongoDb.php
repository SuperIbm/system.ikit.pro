<?php
/**
 * Кеширование.
 * Этот пакет содержит драйвера для различных способов хранения кеша.
 *
 * @package App.Models.Caches
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Caches;

use Illuminate\Contracts\Cache\Store;
use Illuminate\Cache\TaggableStore;
use Config;
use DB;
use Jenssegers\Mongodb\Connection;
use MongoDB\BSON\UTCDateTime;
use DateTime;
use DateInterval;

/**
 * Класс драйвер кеша на основе Memcache.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CacheMongoDb extends TaggableStore implements Store
{
    /**
     * Объект кеширования на основе Memcache.
     *
     * @var \Jenssegers\Mongodb\Connection
     * @since 1.0
     * @version 1.0
     */
    private $_connection;

    /**
     * Название индекса, который хранит кеш.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private $_indexCaches = "cache";

    /**
     * Конструктор.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct()
    {
        $this->setConnection();
    }


    /**
     * Создание соединения с сервером кеширования.
     *
     * @return bool Возвращает статус удачности соединения.
     * @since 1.0
     * @version 1.0
     */
    public function setConnection(): bool
    {
        $connection = DB::connection(Config::get("database.connections.mongodb.driver"));

        if($connection)
        {
            /**
             * @var \Jenssegers\Mongodb\Connection $connection
             */
            $this->_setConnection($connection);
            return true;
        }
        else return false;
    }


    /**
     * Получение кеша по ключу.
     *
     * @param string $key Ключ.
     *
     * @return mixed Значение ключа.
     * @since 1.0
     * @version 1.0
     */
    public function get($key)
    {
        $index = $this->getPrefix() . $key;
        $result = $this->getCollection()->where('key', $index)->first();

        if(!is_null($result))
        {
            if(microtime(true) >= $result['expiration']->toDateTime()->format("U"))
            {
                $this->forget($key);
                return null;
            }
            else
            {
                if($result['value']) return unserialize($result['value']);
                else return null;
            }
        }

        return null;
    }

    /**
     * Запись кеша.
     *
     * @param string $key Ключ.
     * @param mixed $value Значение кеша.
     * @param int $minutes Количество минут, на которые нужно запомнить кешь.
     *
     * @return bool Статус удачности записи.
     * @since 1.0
     * @version 1.0
     */
    public function put($key, $value, $minutes): bool
    {
        $index = $this->getPrefix() . $key;
        $dateTime = new DateTime();
        $dateInterval = new DateInterval('PT'.$minutes.'M');
        $dateTime->add($dateInterval);
        $expiration = new UTCDateTime($dateTime);

        $data = [
            'expiration' => $expiration,
            'key' => $index,
            'value' => serialize($value)
        ];

        $item = $this->getCollection()->where('key', $index)->first();

        if(is_null($item)) $status = $this->getCollection()->insert($data);
        else $status = $this->getCollection()->where('key', $index)->update($data);

        return $status;
    }

    /**
     * Инкреминирование значения.
     *
     * @param string $key Ключ.
     * @param int $value Значение инкремента.
     *
     * @return int Значение после инкриминирования.
     * @since 1.0
     * @version 1.0
     */
    public function increment($key, $value = 1): int
    {
        $value = $this->get($key);

        if(is_numeric($value)) $value++;

        return $this->put($key, $value, 5256000);
    }

    /**
     * Декриминирование значения.
     *
     * @param string $key Ключ.
     * @param int $value Значение инкремента.
     *
     * @return int Значение после декриминирование.
     * @since 1.0
     * @version 1.0
     */
    public function decrement($key, $value = 1): int
    {
        $value = $this->get($key);

        if(is_numeric($value)) $value--;

        return $this->put($key, $value, 5256000);
    }

    /**
     * Запись кеша на неограниченое количество времени.
     *
     * @param string $key Ключ.
     * @param mixed $value Значение кеша.
     *
     * @return bool Статус удачности записи.
     * @since 1.0
     * @version 1.0
     */
    public function forever($key, $value): bool
    {
        return $this->put($key, $value, 5256000);
    }

    /**
     * Удаление кеша по ключу.
     *
     * @param string $key Ключ.
     *
     * @return bool Статус удачности удаления.
     * @since 1.0
     * @version 1.0
     */
    public function forget($key): bool
    {
        $index = $this->getPrefix() . $key;
        $item = $this->getCollection()->where('key', $index)->first();

        if(!is_null($item)) return $this->getCollection()->where('key', $index)->delete();

        return true;
    }

    /**
     * Полная очистка закешированных данных.
     *
     * @return bool Статус удачности очистки.
     * @since 1.0
     * @version 1.0
     */
    public function flush(): bool
    {
        $collection = $this->getConnection()->getCollection(Config::get("cache.stores.mongodb.table"));
        $status = $collection->drop();

        return $status ? true : false;
    }

    /**
     * Получение префикса кеширования для проекта.
     *
     * @return string Префикс для кеширования.
     * @since 1.0
     * @version 1.0
     */
    public function getPrefix(): string
    {
        return $this->_indexCaches;
    }

    /**
     * Получение закешированных данных по набору из ключей.
     *
     * @param array $keys Ключи для получения данных.
     *
     * @return array Массив значений для введенных ключей.
     * @since 1.0
     * @version 1.0
     */
    public function many(array $keys): array
    {
        $data = [];

        for($i = 0; $i < count($keys); $i++)
        {
            $data[$keys[$i]] = $this->get($keys[$i]);
        }

        return $data;
    }

    /**
     * Сохранение закешированных данных по набору из значений.
     *
     * @param array $values Массив данных с ключами.
     * @param int $minutes Количество минут, на которые нужно запомнить кешь.
     *
     * @return bool Вернет статус удачности операции.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function putMany(array $values, $minutes): bool
    {
        foreach($values as $key => $value)
        {
            $this->put($key, $value, $minutes);
        }

        return true;
    }

    /**
     * Получение объекта кеширования на основе Memcache.
     *
     * @return \Jenssegers\Mongodb\Connection Объект соединения с базой данных MongoDb.
     * @since 1.0
     * @version 1.0
     */
    public function getConnection(): Connection
    {
        return $this->_connection;
    }

    /**
     * Получение объекта кеширования на основе Memcache.
     *
     * @param \Jenssegers\Mongodb\Connection $connection Объект соединения с базой данных MongoDb.
     *
     * @return \App\Models\Caches\CacheMongoDb
     * @since 1.0
     * @version 1.0
     */
    private function _setConnection(Connection $connection): CacheMongoDb
    {
        $this->_connection = $connection;

        return $this;
    }

    /**
     * Получение коллекции базы данных.
     *
     * @return \Jenssegers\Mongodb\Query\Builder
     * @since 1.0
     * @version 1.0
     */
    protected function getCollection()
    {
        return $this->getConnection()->collection(Config::get("cache.stores.mongodb.table"));
    }
}