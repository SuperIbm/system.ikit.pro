<?php
/**
 * Модуль предупреждений.
 * Этот модуль содержит все классы для работы с предупреждениями.
 *
 * @package App\Modules\Alert
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Alert\Models;

use App\Modules\Alert\Repositories\Alert;
use App\Models\Error;

/**
 * Класс для работы с предупреждениями.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AlertImplement
{
    use Error;

    /**
     * Репозитарий работы с предупреждениями.
     *
     * @var \App\Modules\Alert\Repositories\Alert
     * @version 1.0
     * @since 1.0
     */
    protected $_alert;

    /**
     * Конструктор.
     *
     * @param \App\Modules\Alert\Repositories\Alert $alert Репозитарий работы с предупреждениями.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Alert $alert)
    {
        $this->_alert = $alert;
    }

    /**
     * Добавить предупреждение.
     *
     * @param string $title Заголовок.
     * @param bool $read Если поставить true то будет иметь статус прочитанного.
     * @param string $description Описание.
     * @param string $url Ссылка.
     * @param string $icon Иконка.
     * @param string $color Цвет иконки.
     *
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function add(string $title, bool $read = false, string $description = null, string $url = null, string $icon = null, string $color = null)
    {
        $data = $this->_alert->create([
            "title" => $title,
            "read" => !$read,
            "description" => $description,
            "url" => $url,
            "icon" => $icon,
            "color" => $color,
        ]);

        if($data) return $data;
        else
        {
            $this->setErrors($this->_alert->getErrors());
            return false;
        }
    }

    /**
     * Изменить предупреждение.
     *
     * @param int $id ID предупреждения.
     * @param string $title Заголовок.
     * @param bool $read Если поставить true то будет иметь статус прочитанного.
     * @param string $description Описание.
     * @param string $url Ссылка.
     * @param string $icon Иконка.
     * @param string $color Цвет иконки.
     *
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function edit(int $id, string $title, bool $read = false, string $description = null, string $url = null, string $icon = null, string $color = null)
    {
        $data = $this->_alert->update($id, [
            "title" => $title,
            "status" => $read,
            "description" => $description,
            "url" => $url,
            "icon" => $icon,
            "color" => $color,
        ]);

        if($data) return $data;
        else
        {
            $this->setErrors($this->_alert->getErrors());
            return false;
        }
    }

    /**
     * Удалить предупреждение.
     *
     * @param int|array $ids ID предупреждения.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function remove($ids): bool
    {
        $data = $this->_alert->destroy($ids);

        if($data) return $data;
        else
        {
            $this->setErrors($this->_alert->getErrors());
            return false;
        }
    }

    /**
     * Установить статус предупреждения как прочитанный.
     *
     * @param int $id ID предупреждения.
     *
     * @return bool Вернет успешность установки статуса.
     * @since 1.0
     * @version 1.0
     */
    public function toRead(int $id): bool
    {
        $data = $this->_alert->get($id);

        if($data)
        {
            $this->edit($id, $data["title"], false, $data["description"], $data["url"], $data["icon"], $data["color"]);

            if($this->hasError())
            {
                $this->setErrors($this->_alert->getErrors());
                return false;
            }
            else return true;
        }
        else return false;
    }

    /**
     * Установить статус предупреждения как не прочитанный.
     *
     * @param int $id ID предупреждения.
     *
     * @return bool Вернет успешность установки статуса.
     * @since 1.0
     * @version 1.0
     */
    public function toUnread(int $id): bool
    {
        $data = $this->_alert->get($id);

        if($data)
        {
            $this->edit($id, $data["title"], true, $data["description"], $data["url"], $data["icon"], $data["color"]);

            if($this->hasError())
            {
                $this->setErrors($this->_alert->getErrors());
                return false;
            }
            else return true;
        }
        else return false;
    }

    /**
     * Получение предупреждения по его ID.
     *
     * @param int $id ID предупреждения.
     *
     * @return array Вернет данные предупреждения.
     * @since 1.0
     * @version 1.0
     */
    public function get(int $id)
    {
        return $this->_alert->get($id);
    }

    /**
     * Получить список предупреждений.
     *
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param bool $unread Получить только не прочтанные предупреждения.
     * @param array $filters Массив фильтров.
     * @param array $sort Массив сортировок.
     *
     * @return array|bool Вернет массив данных предупреждений.
     * @since 1.0
     * @version 1.0
     */
    public function list(int $offset = null, $limit = null, $unread = null, $filters = null, $sort = null)
    {
        $sort = $sort ? $sort : [
            [
                "property" => "created_at",
                "direction" => "DESC"
            ]
        ];

        $data = $this->_alert->read($filters, $unread, $sort, $offset, $limit);

        if(!$this->hasError()) return $data;
        {
            $this->setErrors($this->_alert->getErrors());
            return false;
        }
    }
}