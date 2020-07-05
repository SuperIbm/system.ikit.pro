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
 * Класс действия для получение разделов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SectionMenuAction extends Action
{
    /**
     * Репозитарий разделов системы.
     *
     * @var \App\Modules\Section\Repositories\Section
     * @version 1.0
     * @since 1.0
     */
    private $_section;

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
        $items = $this->_section->read(null, true, [
            [
                'property' => 'bundle',
                'direction' => 'ASC'
            ],
            [
                'property' => 'weight',
                'direction' => 'ASC'
            ]
        ]);

        if(!$this->_section->hasError())
        {
            $result = [];

            for($i = 0; $i < count($items); $i++)
            {
                if(!isset($result[$items[$i]["bundle"]]))
                {
                    $result[$items[$i]["bundle"]] = [
                        "name" => Config::get("section.bundles")[$items[$i]["bundle"]]["name"],
                        "icon" => Config::get("section.bundles")[$items[$i]["bundle"]]["icon"],
                        "key" => $items[$i]["bundle"],
                        "items" => []
                    ];
                }

                if(Gate::allows("section", [
                    $items[$i]["index"],
                    "read"
                ])) $result[$items[$i]["bundle"]]["items"][] = $items[$i];
            }

            foreach($result as $bundle => $section)
            {
                if(!count($result[$bundle]["items"])) unset($result[$bundle]);
            }

            $result = collect($result)->sortBy(function($product, $key) {
                return Config::get("section.bundles")[$key]["index"];
            });

            return $result;
        }
        else
        {
            $this->setErrors($this->_section->getErrors());
            return false;
        }
    }
}
