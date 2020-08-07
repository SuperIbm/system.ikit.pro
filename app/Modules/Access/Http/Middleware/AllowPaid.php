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
 * Класс посредник для проверки пользователя, что система оплачена.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AllowPaid
{
    /**
     * Проверка пользователя.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @param \Closure $next Функция последющего действия.
     * @param array|null $params Параметры доступа.
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next, ...$params)
    {
        if(Gate::allows("paid", $params)) return $next($request);
        else
        {
            $status = isset($params[0]) ? $params[0] : true;
            return $this->_getError($request->ajax(), $status);
        }
    }

    /**
     * Получить ошибку.
     *
     * @param bool $ajax Определяет является ли данный запрос AJAX запросом.
     * @param bool $status Если указать true, то проверить оплаченность, если false, то неоплаченность.
     *
     * @return mixed Вернет ошибку.
     */
    private function _getError($ajax, $status)
    {
        if($ajax)
        {
            return response()->json([
                'success' => false,
                'message' => $status ? 'Access to this part of the application is not allowed because of the unpaid plan!' : 'Access to this part of the application is not allowed because of the paid plan!'
            ]);
        }
        else if(Config::get('auth.redirections.login')) return redirect(Config::get('auth.redirections.login'));
        else if(Config::get('auth.redirections.register')) return redirect(Config::get('auth.redirections.login'));
        else return response($status ? 'Unpaid!' : 'Paid!', 401);
    }
}
