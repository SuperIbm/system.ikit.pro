<?php
/**
 * Модуль Рефералов.
 * Этот модуль содержит все классы для работы с рефералами.
 *
 * @package App\Modules\Referral
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Referral\Repositories;

use App\Models\Repository;
use App\Models\RepositoryEloquent;

/**
 * Класс рефералов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Referral extends Repository
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
    public function get(int $id = null, bool $active = null, array $filters = null, array $with = null): ?array
    {
        return $this->_get(['Referral', 'ReferralItem'], $id, $active, $filters, $with);
    }

    /**
     * Чтение данных.
     *
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $sorts Массив значений для сортировки.
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param array $with Массив связанных моделей.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function read(array $filters = null, bool $active = null, array $sorts = null, int $offset = null, int $limit = null, array $with = null): ?array
    {
        return $this->_read([
            'Referral',
            'ReferralItem'
        ], false, $filters, $active, $sorts, $offset, $limit, $with);
    }

    /**
     * Подсчет общего количества записей.
     *
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $with Массив связанных моделей.
     *
     * @return int Количество.
     * @since 1.0
     * @version 1.0
     */
    public function count(array $filters = null, bool $active = null, array $with = null): ?int
    {
        return $this->_read(['Referral', 'ReferralItem'], true, $filters, $active, null, null, null, $with);
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
        return $this->_create(['ReferralItem'], $data);
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
        return $this->_update(['ReferralItem'], $id, $data);
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
        return $this->_destroy(['ReferralItem'], $id, $filters);
    }
}
