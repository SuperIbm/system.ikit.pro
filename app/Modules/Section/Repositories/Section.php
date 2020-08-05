<?php
/**
 * Модуль Разделы системы.
 * Этот модуль содержит все классы для работы с разделами системы.
 *
 * @package App\Modules\Section
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Section\Repositories;

use App\Models\Repository;
use App\Models\RepositoryTreeEloquent;

/**
 * Класс репозитария разделов на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Section extends Repository
{
    use RepositoryTreeEloquent;

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
        return $this->_get(['Section', 'SectionItem'], $id, $active, $filters, $with);
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
     * @param array $groups Массив для группировки.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function read(array $filters = null, bool $active = null, array $sorts = null, int $offset = null, int $limit = null, array $with = null, array $groups = null): ?array
    {
        return $this->_read([
            'Section',
            'SectionItem'
        ], false, $filters, $active, $sorts, $offset, $limit, $with, $groups);
    }

    /**
     * Получение дерева разделов.
     *
     * @param array $filters Фильтрация данных.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     * @param array $with Массив связанных моделей.
     *
     * @return array Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function tree(array $filters = null, $active = null, array $with = null)
    {
        $tree = $this->_tree(['Section', 'SectionItem'], $filters, $active, null, $with);

        return $tree;
    }

    /**
     * Получение всех родительских разделов.
     *
     * @param int $id ID раздела у которой нужно получить всех родителей.
     *
     * @return array Вернет массив разделов.
     * @since 1.0
     * @version 1.0
     */
    public function parents(int $id)
    {
        return $this->_parents(['Section', 'SectionItem'], $id);
    }

    /**
     * Получение всех потомков раздела.
     *
     * @param int $id ID раздела у которого нужно получить всех потомков.
     *
     * @return array Вернет массив разделов.
     * @since 1.0
     * @version 1.0
     */
    public function children(int $id)
    {
        return $this->_children(['Section', 'SectionItem'], $id);
    }

    /**
     * Поднятие узла.
     *
     * @param int $id ID раздела у которой нужно получить всех потомков.
     * @param int $amount На какое количество поднять узел.
     *
     * @return bool Вернет успешность операци.
     * @since 1.0
     * @version 1.0
     */
    public function up(int $id, int $amount = 1): bool
    {
        $status = $this->_up(['PageItem'], $id, $amount);
        $this->_fix();

        return $status;
    }

    /**
     * Опускание узла.
     *
     * @param int $id ID раздела у которой нужно получить всех потомков.
     * @param int $amount На какое количество опустить узел.
     *
     * @return bool Вернет успешность операци.
     * @since 1.0
     * @version 1.0
     */
    public function down(int $id, int $amount = 1): bool
    {
        $status = $this->_down(['PageItem'], $id, $amount);
        $this->_fix();

        return $status;
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
        return $this->_read(['Section', 'SectionItem'], true, $filters, $active, null, null, null, $with);
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
        return $this->_create(['SectionItem'], $data);
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
        return $this->_update(['SectionItem'], $id, $data);
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
        return $this->_destroy(['SectionItem'], $id, $filters);
    }
}
