<?php
/**
 * Модуль Запоминания действий.
 * Этот модуль содержит все классы для работы с запоминанием и контролем действий пользователя.
 *
 * @package App\Modules\Act
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Act\Repositories;

use App\Models\RepositoryEloquent;
use App\Models\Repository;

/**
 * Класс репозитария действий на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Act extends Repository
{
    use RepositoryEloquent;

    /**
     * Количество минут на сколько должен сохранятся кешь.
     *
     * @var int
     * @version 1.0
     * @since 1.0
     */
    protected $_cacheMinutes = 1;

    /**
     * Получить по первичному ключу.
     *
     * @param int $id Первичный ключ.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function get($id)
    {
        return $this->_get(['Act', 'ActItem'], $id);
    }

    /**
     * Чтение данных.
     *
     * @param array $filters Фильтрация данных.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function read($filters = null, $sorts = null, $offset = null, $limit = null)
    {
        return $this->_read(['Act', 'ActItem'], false, $filters, null, $sorts, $offset, $limit);
    }

    /**
     * Подсчет общего количества записей.
     *
     * @param array $filters Фильтрация данных.
     *
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count($filters = null)
    {
        return $this->_read(['Act', 'ActItem'], true, $filters);
    }

    /**
     * Создание.
     *
     * @param array $data Данные для добавления.
     *
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function create(array $data)
    {
        return $this->_create(['ActItem'], $data);
    }

    /**
     * Обновление.
     *
     * @param int $id Id записи для обновления.
     * @param array $data Данные для обновления.
     *
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function update($id, array $data)
    {
        return $this->_update(['ActItem'], $id, $data);
    }

    /**
     * Удаление.
     *
     * @param int|array $id Id записи для удаления.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function destroy($id)
    {
        return $this->_destroy(['ActItem'], $id);
    }
}
