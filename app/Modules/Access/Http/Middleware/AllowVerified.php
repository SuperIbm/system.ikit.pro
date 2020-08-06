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
 * Класс посредник для проверки пользователя, что он верифицирован или не верефицирован.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AllowVerified
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
        if(Gate::allows('user'))
        {
            $status = isset($params[0]) ? $params[0] : true;

            if(Gate::allows('verified', $status)) return $next($request);
            else return $this->_getError($request->ajax(), $status);
        }
        else return $this->_getError($request->ajax());
    }

    /**
     * Получить ошибку.
     *
     * @param bool $ajax Определяет являеться ли данный запрос AJAX запросом.
     * @param bool $status Если указан true, то проверить что пользователь верифицирован, если false, то не верефицирован.
     *
     * @return mixed Вернет ошибку.
     */
    private function _getError($ajax, $status = true)
    {
        if($ajax)
        {
            return response()->json([
                'success' => false,
                'message' => $status ? 'Access to this part of the application only for a verified user!' : 'Access to this part of the application only for a unverified user!'
            ]);
        }
        else if(Config::get('auth.redirections.verify') && $status) return redirect(Config::get('auth.redirections.verify'));
        else if(Config::get('auth.redirections.unverify') && !$status) return redirect(Config::get('auth.redirections.unverified'));
        else if($status) return response('Unverified!', 401);
        else return response('Verified!', 401);
    }
}
