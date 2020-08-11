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
use School;

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
    protected Alert $_alert;

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
     * @param int $school ID школы.
     *
     * @return int Вернет ID последней вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function add(string $title, bool $read = false, string $description = null, string $url = null, string $icon = null, string $color = null, int $school = null)
    {
        $school = School::getId() ? School::getId() : $school;

        $data = $this->_alert->create([
            "title" => $title,
            "read" => !$read,
            "description" => $description,
            "url" => $url,
            "icon" => $icon,
            "color" => $color,
            'school_id' => $school
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
     * @param int $school ID школы.
     *
     * @return int Вернет ID вставленной строки. Если ошибка, то вернет false.
     * @since 1.0
     * @version 1.0
     */
    public function edit(int $id, string $title, bool $read = false, string $description = null, string $url = null, string $icon = null, string $color = null, int $school = null)
    {
        $data = [];

        if(isset($title)) $data["title"] = $title;
        if(isset($read)) $data["status"] = $read;
        if(isset($description)) $data["description"] = $description;
        if(isset($url)) $data["url"] = $url;
        if(isset($icon)) $data["icon"] = $icon;
        if(isset($color)) $data["color"] = $color;
        if(isset($school)) $data["school"] = $school;

        $data = $this->_alert->update($id, $data);

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
     * @param int $school ID школы.
     *
     * @return bool Вернет булево значение успешности операции.
     * @since 1.0
     * @version 1.0
     */
    public function remove($ids, int $school = null): bool
    {
        $school = School::getId() ? School::getId() : $school;

        $filter = [
            [
                'table' => 'alerts',
                'property' => 'id',
                'operator' => 'IN',
                'value' => $ids
            ],
            [
                'table' => 'alerts',
                'property' => 'school_id',
                'value' => $school
            ]
        ];

        $data = $this->_alert->destroy(null, $filter);

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
     * @param int $school ID школы.
     *
     * @return bool Вернет успешность установки статуса.
     * @since 1.0
     * @version 1.0
     */
    public function toRead(int $id, int $school = null): bool
    {
        $school = School::getId() ? School::getId() : $school;

        $filter = [
            [
                'table' => 'alerts',
                'property' => 'id',
                'value' => $id
            ],
            [
                'table' => 'alerts',
                'property' => 'school_id',
                'value' => $school
            ]
        ];

        $alert = $this->_alert->get(null, null, $filter);

        if($alert)
        {
            $this->edit($id, null, false);

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
     * @param int $school ID школы.
     *
     * @return bool Вернет успешность установки статуса.
     * @since 1.0
     * @version 1.0
     */
    public function toUnread(int $id, int $school = null): bool
    {
        $school = School::getId() ? School::getId() : $school;

        $filter = [
            [
                'table' => 'alerts',
                'property' => 'id',
                'value' => $id
            ],
            [
                'table' => 'alerts',
                'property' => 'school_id',
                'value' => $school
            ]
        ];

        $alert = $this->_alert->get(null, null, $filter);

        if($alert)
        {
            $this->edit($id, null, true);

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
     * @param int $school ID школы.
     *
     * @return array Вернет данные предупреждения.
     * @since 1.0
     * @version 1.0
     */
    public function get(int $id, int $school = null): ?array
    {
        $school = School::getId() ? School::getId() : $school;

        $filter = [
            [
                'table' => 'alerts',
                'property' => 'id',
                'value' => $id
            ],
            [
                'table' => 'alerts',
                'property' => 'school_id',
                'value' => $school
            ]
        ];

        return $this->_alert->get(null, true, $filter);
    }

    /**
     * Получить список предупреждений.
     *
     * @param int $offset Отступ вывода.
     * @param int $limit Лимит вывода.
     * @param bool $unread Получить только не прочтанные предупреждения.
     * @param array $filters Массив фильтров.
     * @param array $sort Массив сортировок.
     * @param int $school ID школы.
     *
     * @return array|bool Вернет массив данных предупреждений.
     * @since 1.0
     * @version 1.0
     */
    public function list(int $offset = null, $limit = null, $unread = null, $filters = null, $sort = null, int $school = null)
    {
        $sort = $sort ? $sort : [
            [
                "property" => "created_at",
                "direction" => "DESC"
            ]
        ];

        $filter[] = [
            'table' => 'alerts',
            'property' => 'school_id',
            'value' => $school
        ];

        $data = $this->_alert->read($filters, $unread, $sort, $offset, $limit);

        if(!$this->hasError()) return $data;
        {
            $this->setErrors($this->_alert->getErrors());
            return false;
        }
    }
}
