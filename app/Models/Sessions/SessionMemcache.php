<?php
/**
 * Сессии.
 * Этот пакет содержит драйвера для разных хранилищь сессий.
 *
 * @package App.Models.Session
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Sessions;

use Config;
use SessionHandlerInterface;
use \Memcache;

/**
 * Класс драйвер сессии на основе Memcache.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SessionMemcache implements SessionHandlerInterface
{
    /**
     * Объект кеширования на основе Memcache.
     *
     * @var \Memcache
     * @version 1.0
     * @since 1.0
     */
    private $_memcache;

    /**
     * Название индекса, который хранит сессии.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    private $_indexSessions = "sessions";

    /**
     * Конструктор.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct()
    {
        $this->_setCache(new Memcache());
        $this->getCache()->connect(Config::get("session.memcache.host"), Config::get("session.memcache.port"));
    }

    /**
     * Метод открытия системы сессий.
     *
     * @param string $savePath Путь записи.
     * @param string $sessionName Название сессии.
     *
     * @return bool Возвращает удачность открытия сессии.
     * @since 1.0
     * @version 1.0
     */
    public function open($savePath, $sessionName): bool
    {
        return true;
    }

    /**
     * Метод закрытия системы сессий.
     *
     * @return bool Возвращает удачность открытия сессии.
     * @since 1.0
     * @version 1.0
     */
    public function close(): bool
    {
        return true;
    }

    /**
     * Считывыне сессии.
     *
     * @param string $sessionId ID сессии.
     *
     * @return mixed Вернет значение сессии.
     * @since 1.0
     * @version 1.0
     */
    public function read($sessionId)
    {
        $index = Config::get("app.url") . "_" . $this->_indexSessions;
        $data = $this->getCache()->get($index);

        if($data)
        {
            if(isset($data[$sessionId])) return $data[$sessionId];
            else return null;
        }
        return null;
    }

    /**
     * Запись сессии.
     *
     * @param string $sessionId ID сессии.
     * @param mixed $data Данные на запись.
     *
     * @return bool Удачность записи.
     * @since 1.0
     * @version 1.0
     */
    public function write($sessionId, $data): bool
    {
        $index = Config::get("app.url") . "_" . $this->_indexSessions;
        $result = $this->getCache()->get($index);

        if(isset($result)) $result[$sessionId] = $data;
        else
        {
            $result = [
                [
                    $sessionId => $data
                ]
            ];
        }

        $compress = Config::get("cache.stores.memcache.compress") ? MEMCACHE_COMPRESSED : 0;
        return $this->getCache()->set($index, $result, $compress, Config::get("session.lifetime") * 60);
    }

    /**
     * Уничтожение сессии.
     *
     * @param string $sessionId ID сессии.
     *
     * @return bool Удачность удаления.
     * @since 1.0
     * @version 1.0
     */
    public function destroy($sessionId): bool
    {
        $index = Config::get("app.url") . "_" . $this->_indexSessions;
        $data = $this->getCache()->get($index);

        if(isset($data))
        {
            if(isset($data[$sessionId]))
            {
                unset($data[$sessionId]);
                $compress = Config::get("cache.stores.memcache.compress") ? MEMCACHE_COMPRESSED : 0;
                $this->getCache()->set($index, $data, $compress, Config::get("session.lifetime") * 60);
            }
        }

        return true;
    }

    /**
     * Конвертация времени жизни сессии.
     *
     * @param string $lifetime Время жизни.
     *
     * @return bool Возвращенное значение конвертации.
     * @since 1.0
     * @version 1.0
     */
    public function gc($lifetime): bool
    {
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
     * @param \Memcache $memcache Объект кеширования на основе Memcache.
     *
     * @return \App\Models\Sessions\SessionMemcache
     * @since 1.0
     * @version 1.0
     */
    private function _setCache(Memcache $memcache): SessionMemcache
    {
        $this->_memcache = $memcache;
        return $this;
    }
}
