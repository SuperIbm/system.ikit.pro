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
 * Класс посредник для проверки пользователя, что он относиться к данной школе.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AllowSchool
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
        if(Gate::allows("school", $params)) return $next($request);
        else return $this->_getError($request->ajax());
    }

    /**
     * Получить ошибку.
     *
     * @param bool $ajax Определяет являеться ли данный запрос AJAX запросом.
     *
     * @return mixed Вернет ошибку.
     */
    private function _getError($ajax)
    {
        if($ajax)
        {
            return response()->json([
                'success' => false,
                'message' => 'Access to this part of the application is not allowed!'
            ]);
        }
        else if(Config::get('auth.redirections.login')) return redirect(Config::get('auth.redirections.login'));
        else if(Config::get('auth.redirections.register')) return redirect(Config::get('auth.redirections.login'));
        else return response('Restricted!', 401);
    }
}
