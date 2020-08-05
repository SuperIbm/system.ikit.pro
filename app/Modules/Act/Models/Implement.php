<?php
/**
 * Модуль Запоминания действий.
 * Этот модуль содержит все классы для работы с запоминанием и контролем действий пользователя.
 *
 * @package App\Modules\Act
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Act\Models;

use App\Modules\Act\Repositories\Act;
use Carbon\Carbon;
use Request;

/**
 * Класс запоминания действий пользователя.
 * Класс, который позволяет вести учет действий пользователя, если требуется контролировать, сколько раз он имеет право его выполнить
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Implement
{
    /**
     * Репозитарий действий.
     *
     * @var \App\Modules\Act\Repositories\Act
     * @version 1.0
     * @since 1.0
     */
    private Act $_act;

    /**
     * Конструктор.
     *
     * @param \App\Modules\Act\Repositories\Act $act Репозитарий действий.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Act $act)
    {
        $this->_act = $act;
    }

    /**
     * Проверка статуса действий.
     * Позволяет определить, сколько раз выполнялось действие и может ли действие снова быть осуществлено.
     *
     * @param string $index Индекс действия.
     * @param int $maxCount Сколько раз это действий может быть исполнено.
     * @param int $minutes Через сколько минут это действие будет доступно.
     *
     * @return bool Если вернет true, то действие может быть выполнено еще раз. Если false, то максимальный порог его выполнения достигнут.
     * @since 1.0
     * @version 1.0
     */
    public function status(string $index, int $maxCount, int $minutes = 60): bool
    {
        $index = $this->_getKey($index);
        $value = $this->_get($index);

        if($value)
        {
            $value["time"] = Carbon::createFromFormat("Y-m-d H:i:s", $value["time"]);
            $timeCurrent = Carbon::now();
            $timeEnd = $value["time"]->addMinutes($minutes);

            if($timeCurrent >= $timeEnd)
            {
                $this->_clean($index);
                return true;
            }
            else
            {
                if($value["count"] <= $maxCount) return true;
                else return false;
            }
        }
        else return true;
    }

    /**
     * Добавление действия.
     *
     * @param string $index Индекс действия.
     * @param int $to Добавить к количеству выполненных действий.
     * @param int $minutes Общее время жизни этой записи в минутах.
     *
     * @return \App\Modules\Act\Models\Implement
     * @since 1.0
     * @version 1.0
     */
    public function add(string $index, int $to = 1, int $minutes = 60 * 24 * 31): Implement
    {
        $index = $this->_getKey($index);

        $value = $this->_get($index, [
            "count" => 0,
            "minutes" => $minutes,
            "time" => Carbon::now(),
        ]);

        $value["count"] += $to;
        $this->_set($index, $value["count"], $value["minutes"]);

        return $this;
    }

    /**
     * Очистка истории действий.
     * Позволяет удалить всю историю об этом действии, заодно обнулив весь результат.
     *
     * @param string $index Индекс действия.
     *
     * @return \App\Modules\Act\Models\Implement
     * @since 1.0
     * @version 1.0
     */
    public function delete(string $index): Implement
    {
        $index = $this->_getKey($index);
        $this->_clean($index);

        return $this;
    }

    /**
     * Получение действия по индексу.
     *
     * @param string $index Индекс действия.
     * @param array $default Значение по умолчанию, если значение отсуствует.
     *
     * @return array Возвращает массив значений действия.
     * @since 1.0
     * @version 1.0
     */
    protected function _get(string $index, array $default = null): ?array
    {
        $filters = [
            [
                "table" => "acts",
                "property" => "index",
                "operator" => "=",
                "value" => $index,
                "logic" => "and"
            ],
        ];

        $records = $this->_act->read($filters);

        if($records)
        {
            $record = $records[0];

            return [
                "count" => $record["count"],
                "minutes" => $record["minutes"],
                "time" => $record["updated_at"]
            ];
        }
        else if($default) return $default;
        else return null;
    }


    /**
     * Запись действия.
     *
     * @param string $index Индекс действия.
     * @param int $count Попыток действий.
     * @param int $minutes Количество минут через которые действией можно будет повторить.
     * @param int $time Время в Unix формате, когда действие было произведено.
     *
     * @return \App\Modules\Act\Models\Implement
     * @since 1.0
     * @version 1.0
     */
    protected function _set(string $index, int $count, int $minutes, int $time = null): Implement
    {
        $time = isset($time) ? $time : time();

        $filters = [
            [
                "table" => "acts",
                "property" => "index",
                "operator" => "=",
                "value" => $index,
                "logic" => "and"
            ],
        ];

        $records = $this->_act->read($filters);

        if($records)
        {
            $record = $records[0];

            $this->_act->update($record["id"], [
                "index" => $index,
                "count" => $count,
                "minutes" => $minutes,
                "time" => Carbon::now()
            ]);
        }
        else
        {
            $this->_act->create([
                "index" => $index,
                "count" => $count,
                "minutes" => $minutes,
                "time" => $time
            ]);
        }

        return $this;
    }

    /**
     * Очистка истории действий.
     * Позволяет удалить всю историю об этом действии, заодно обнулив весь результат.
     *
     * @param string $index Индекс действия.
     *
     * @return \App\Modules\Act\Models\Implement
     * @since 1.0
     * @version 1.0
     */
    protected function _clean(string $index): Implement
    {
        $filters = [
            [
                "table" => "acts",
                "property" => "index",
                "operator" => "=",
                "value" => $index,
                "logic" => "and"
            ],
        ];

        $records = $this->_act->read($filters);

        if($records)
        {
            for($i = 0; $i < count($records); $i++)
            {
                $this->_act->destroy($records[$i]["id"]);
            }
        }

        return $this;
    }


    /**
     * Получение ключа по индексу.
     *
     * @param string $index Индекс действия.
     *
     * @return string Ключ.
     * @since 1.0
     * @version 1.0
     */
    protected function _getKey(string $index): string
    {
        return md5("action." . Request::ip() . "." . $index);
    }
}
