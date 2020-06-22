<?php
/**
 * Основные посредники.
 *
 * @package App.Http.Middleware
 * @version 1.0
 * @since 1.0
 */

namespace App\Http\Middleware;

use Closure;
use Config;
use Illuminate\Http\Request;


/**
 * Класс посредник для проверки идет ли этот запрос через AJAX.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AllowOnlyAjaxRequests
{
    /**
     * Проверка запроса, который пришел как AJAX.
     * Если в конфиге app.env установлено 'local', то запрос пройдет в любом случаи,
     * т.к. считается что система работает на тестинге и проводить жесткий контроль
     * запроса, не требуется.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @param \Closure $next Функция последющего действия.
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->ajax() == false && Config::get("app.env", 'local') == 'production')
        {
            return response('No allowed!', 405);
        }

        return $next($request);
    }
}
