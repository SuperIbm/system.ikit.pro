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

use Cache;
use App\Models\RepositoryEloquent;
use App\Models\Repository;

/**
 * Класс репозитария пользователей на основе Eloquent.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class User extends Repository
{
    use RepositoryEloquent;

    /**
     * Получить по первичному ключу.
     *
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
    public function get(int $id = null, bool $active = null, array $filters = null, array $with = null, array $selects = null): ?array
    {
        return $this->_get(['User', 'UserItem'], $id, $active, $filters, $with, $selects);
    }

    /**
     * Получить все флаги.
     *
     * @param int $id Первичный ключ.
     * @param bool $active Булево значение, если определить как true, то будет получать только активные записи.
     *
     * @return array|bool Массив данных.
     * @since 1.0
     * @version 1.0
     */
    public function flags(int $id, bool $active = null)
    {
        $result = $this->get($id, $active);

        if($result) return $result["flags"];
        else return false;
    }

    /**
     * Установить все флаги.
     *
     * @param int $id Первичный ключ.
     * @param array $flags Массив флагов.
     *
     * @return bool Вернет успешность выполнения операции.
     * @since 1.0
     * @version 1.0
     */
    public function setFlags(int $id, array $flags): bool
    {
        $model = $this->getModel()->find($id);

        if($model)
        {
            $model->setFlags($flags);
            $model->save();

            if(!$model->hasError())
            {
                Cache::tags(['UserItem'])->flush();

                return true;
            }
            else
            {
                $this->setErrors($model->getErrors());

                return false;
            }
        }
        else
        {
            $this->addError("search", "The user doesn't exist.");
            return false;
        }
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
        return $this->_read(['User', 'UserItem'], false, $filters, $active, $sorts, $offset, $limit, $with);
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
        return $this->_read(['User', 'UserItem'], true, $filters, $active, null, null, null, $with);
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
        return $this->_create(['UserItem'], $data);
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
        return $this->_update(['UserItem'], $id, $data);
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
        return $this->_destroy(['UserItem'], $id, $filters);
    }

    /**
     * Получение название уникального токена для пользователя.
     *
     * @return string Вернет название токена.
     * @version 1.0
     * @since 1.0
     */
    public function getRememberTokenName()
    {
        return $this->newInstance()->getRememberTokenName();
    }

    /**
     * Получение название уникального идентификатора для пользователя.
     *
     * @return string Вернет название идентификатора.
     * @version 1.0
     * @since 1.0
     */
    public function getAuthIdentifierName()
    {
        return $this->newInstance()->getAuthIdentifierName();
    }
}
