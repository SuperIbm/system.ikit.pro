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

use Config;
use Closure;
use Illuminate\Http\Request;
use Gate;

/**
 * Класс посредник для проверки пользователя, что он являеться гостем.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AllowGuest
{
    /**
     * Проверка пользователя, что он является не авторизовался.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @param \Closure $next Функция последющего действия.
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Gate::allows('user')) return $next($request);
        else
        {
            if($request->ajax())
            {
                return response()->json([
                    'success' => false,
                    'message' => trans('access::http.middleware.allowGuest.text'),
                ]);
            }
            else if(Config::get('auth.redirections.unregister')) return redirect(Config::get('auth.redirections.unregister'));
            else return response(trans('access::http.middleware.allowGuest.label'), 401);
        }
    }
}
