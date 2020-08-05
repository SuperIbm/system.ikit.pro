<?php
/**
 * Модуль Разделы системы.
 * Этот модуль содержит все классы для работы с разделами системы.
 *
 * @package App\Modules\Section
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Section\Actions;

use Config;
use Gate;
use App\Models\Action;
use App\Modules\Section\Repositories\Section;

/**
 * Класс действия для чтения разделов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SectionReadAction extends Action
{
    /**
     * Репозитарий разделов системы.
     *
     * @var \App\Modules\Section\Repositories\Section
     * @version 1.0
     * @since 1.0
     */
    private Section $_section;

    /**
     * Конструктор.
     *
     * @param \App\Modules\Section\Repositories\Section $section Репозитарий разделов системы.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Section $section)
    {
        $this->_section = $section;
    }

    /**
     * Метод запуска логики.
     *
     * @return mixed Вернет результаты исполнения.
     * @since 1.0
     * @version 1.0
     */
    public function run()
    {
        $items = $this->_section->tree(null, true);

        if(!$this->_section->hasError())
        {
            $items = $this->_getAllows($items);
            return $this->_getClean($items);
        }
        else
        {
            $this->setErrors($this->_section->getErrors());
            return false;
        }
    }

    /**
     * Получить только допустимые разделы.
     *
     * @param array $items Массив разделов.
     *
     * @return array Вернет массив разделов.
     * @since 1.0
     * @version 1.0
     */
    private function _getAllows(array $items): array
    {
        $result = [];

        if($items && count($items))
        {
            for($i = 0; $i < count($items); $i++)
            {
                if(count($items[$i]["children"]) || Gate::allows("section", [$items[$i]["index"], "read"]))
                {
                    $lng = count($result);
                    $result[$lng] = $items[$i];
                    $result[$lng]["leaf"] = count($items[$i]["children"]) == 0 ? true : false;

                    if(count($items[$i]["children"]))
                    {
                        $children = $this->_getAllows($items[$i]["children"]);
                        $result[$lng]["children"] = $children;
                    }
                }
            }
        }

        return $result;
    }

    /**
     * Убрать разделы в которых нет подразделов.
     *
     * @param array $items Массив разделов.
     *
     * @return array Вернет массив разделов.
     * @since 1.0
     * @version 1.0
     */
    private function _getClean(array $items): array
    {
        $result = [];

        if($items && count($items))
        {
            for($i = 0; $i < count($items); $i++)
            {
                if($items[$i]["leaf"] == true || ($items[$i]["leaf"] == false && count($items[$i]["children"])))
                {
                    $lng = count($result);
                    $result[$lng] = $items[$i];

                    if(count($items[$i]["children"]))
                    {
                        $children = $this->_getClean($items[$i]["children"]);
                        $result[$lng]["children"] = $children;
                    }
                }
            }
        }

        return $result;
    }
}
