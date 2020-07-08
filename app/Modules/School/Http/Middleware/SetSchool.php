<?php
/**
 * Модуль Школ.
 * Этот модуль содержит все классы для работы школами.
 *
 * @package App\Modules\School
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\School\Http\Middleware;

use School;
use Closure;
use Illuminate\Http\Request;

/**
 * Установка школы по умолчанию.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SetSchool
{
    /**
     * Установка.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @param \Closure $next Функция последющего действия.
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->get("school"))
        {
            $result = School::setByIndex($request->get("school"));

            if($result) return $next($request);
            else
            {
                $data = [
                    'success' => false,
                    'message' => "School doesn't exist."
                ];

                return response()->json($data)->setStatusCode(400);
            }
        }
        else
        {
            $data = [
                'success' => false,
                'message' => "You have to send school index."
            ];

            return response()->json($data)->setStatusCode(400);
        }
    }
}
