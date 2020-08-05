<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\User\Repositories;

use App\Models\RepositoryEloquent;
use App\Models\Repository;

/**
 * Класс репозитария для ролей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserRole extends Repository
{
    use RepositoryEloquent;

    /**
     * Получить по первичному ключу.
     *
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $filters Фильтрация данных.
     * @param array $with Массив связанных моделей.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function get(int $id = null, bool $active = null, array $filters = null, array $with = null)
    {
        return $this->_get(['User', 'UserItem', 'UserRole'], $id, $active, $filters, $with);
    }

    /**
     * Чтение данных.
     *
     * @param array $filters Фильтрация данных.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param array $with Массив связанных моделей.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function read(array $filters = null, array $sorts = null, int $offset = null, int $limit = null, array $with = null): ?array
    {
        return $this->_read(['User', 'UserItem', 'UserRole'], false, $filters, null, $sorts, $offset, $limit, $with);
    }

    /**
     * Подсчет общего количества записей.
     *
     * @param array $filters Фильтрация данных.
     * @param array $with Массив связанных моделей.
     *
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count(array $filters = null, array $with = null): ?int
    {
        return $this->_read(['User', 'UserItem', 'UserRole'], true, $filters, null, null, null, null, $with);
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
        return $this->_create(['UserItem', 'UserRole'], $data);
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
    public function update(int $id, array $data)
    {
        return $this->_update(['UserItem', 'UserRole'], $id, $data);
    }

    /**
     * Удаление.
     *
     * @param int $id Id записи для удаления.
     * @param array $filters Фильтрация данных.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function destroy(int $id = null, array $filters = null): bool
    {
        return $this->_destroy(['UserItem', 'UserRole'], $id, $filters);
    }
}
