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
use OAuth;
use Auth;

/**
 * Класс посредник для проверки аунтификации через API.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AllowOAuth
{
    /**
     * Проверка пользователя, что он авторизован через API.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @param \Closure $next Функция последющего действия.
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next)
    {
        $header = $request->header('Authorization');

        if($header)
        {
            $token = str_replace("Bearer ", "", $header);
            OAuth::check($token);

            if(!OAuth::hasError())
            {
                $data = OAuth::decode($token, "accessToken");
                Auth::loginUsingId($data["user"]);

                return $next($request);
            }
            else  return abort(401, trans('access::http.middleware.allowOAuth.label') . ": " . OAuth::getErrorMessage());
        }
        else return abort(401, trans('access::http.middleware.allowOAuth.no_header'));
    }
}
