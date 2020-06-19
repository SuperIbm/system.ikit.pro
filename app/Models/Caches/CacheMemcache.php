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
use \Memcache;

/**
 * Класс драйвер кеша на основе Memcache.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CacheMemcache extends TaggableStore implements Store
{
    /**
     * Объект кеширования на основе Memcache.
     *
     * @var \Memcache
     * @since 1.0
     * @version 1.0
     */
    private $_memcache;

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
        $this->_setCache(new Memcache());
        $this->getCache()->connect(config("cache.stores.memcache.host"), config("cache.stores.memcache.port"));

        return true;
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
        $result = $this->getCache()->get($index);

        if($result) return unserialize($result);
        else return null;
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
        $compress = config("cache.stores.memcache.compress") ? MEMCACHE_COMPRESSED : 0;
        $status = $this->getCache()->set($index, serialize($value), $compress, $minutes * 60);

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
        $index = $this->getPrefix() . $key;
        return $this->getCache()->increment($index, serialize($value));
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
        $index = $this->getPrefix() . $key;
        return $this->getCache()->decrement($index, serialize($value));
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
        return $this->put($key, serialize($value), 0);
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
        return $this->getCache()->delete($index);
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
        return $this->getCache()->flush();
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
        $data = Array();

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
     * @return \Memcache Объект кеширования.
     * @since 1.0
     * @version 1.0
     */
    public function getCache(): Memcache
    {
        return $this->_memcache;
    }

    /**
     * Получение объекта кеширования на основе Memcache.
     *
     * @param \Memcache $Memcache Объект кеширования на основе Memcache.
     *
     * @return \App\Models\Caches\CacheMemcache
     * @since 1.0
     * @version 1.0
     */
    private function _setCache(Memcache $Memcache): CacheMemcache
    {
        $this->_memcache = $Memcache;
        return $this;
    }
}