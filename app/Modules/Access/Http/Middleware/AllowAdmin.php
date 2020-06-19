<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Gate;


/**
 * Класс посредник для проверки пользователя, что он является администратором.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AllowAdmin
{
    /**
     * Проверка пользователя, что он является администратором.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @param \Closure $next Функция последющего действия.
     * @param array|null $params Параметры доступа.
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next, ...$params)
    {
        if(!Gate::allows('admin'))
        {
            if($request->ajax())
            {
                return response()->json([
                    'success' => false,
                    'message' => 'Access to this part of the application has ended, please log in again!'
                ]);
            }
            else return response('Unauthorized!', 401);
        }
        else
        {
            if(!empty($params))
            {
                $name = $params[0];
                array_shift($params);

                //print_r($params);

                if(!Gate::allows($name, $params))
                {
                    if($request->ajax())
                    {
                        return response()->json([
                            'success' => false,
                            'message' => 'Access to this part of the application has ended, please log in again!'
                        ]);
                    }
                    else return response('Unauthorized!', 401);
                }
            }
        }

        return $next($request);
    }
}
