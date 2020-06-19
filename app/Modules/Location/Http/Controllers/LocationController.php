<?php
/**
 * Модуль География.
 * Этот модуль содержит все классы для работы с странами, районами, городами и т.д.
 *
 * @package App\Modules\Location
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Location\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Modules\Location\Models\Location;

/**
 * Класс контроллер для работы с географиечскими объектами.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LocationController extends Controller
{
    /**
     * Модель локализации.
     *
     * @var \App\Modules\Location\Models\Location
     * @version 1.0
     * @since 1.0
     */
    private $_location;

    /**
     * Конструктор.
     *
     * @param \App\Modules\Location\Models\Location $location Модель локализации.
     *
     * @since 1.0
     * @version 1.0
     */
    public function __construct(Location $location)
    {
        $this->_location = $location;
    }

    /**
     * Получить все страны.
     *
     * @param Request $request Запрос.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @version 1.0
     * @since 1.0
     */
    public function countries(Request $request)
    {
        $data = $this->_location->getCountries();

        if($data)
        {
            $result = [];

            foreach($data as $code => $value)
            {
                if(is_string($value))
                {
                    $result[] = [
                        "code" => $code,
                        "name" => $value
                    ];
                }
                else
                {
                    $result[] = [
                        "code" => $code,
                        "name" => $value["name"],
                        "telephone_format" => $value["telephone_format"],
                    ];
                }
            }

            $data = [
                'data' => $result,
                'success' => true,
            ];
        }
        else
        {
            $data = [
                'success' => false,
            ];
        }

        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }

    /**
     * Получить регионы по стране.
     *
     * @param string $country Код страны.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @version 1.0
     * @since 1.0
     */
    public function regions(string $country)
    {
        $data = $this->_location->getRegions($country);
        $data = $data ? $data : [];

        $result = [];

        foreach($data as $code => $name)
        {
            $result[] = [
                "code" => $code,
                "name" => $name
            ];
        }

        $data = [
            'data' => $result,
            'success' => true,
        ];


        return response()->json($data)->setStatusCode($data["success"] == true ? 200 : 400);
    }
}
