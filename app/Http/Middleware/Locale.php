<?php
/**
 * Основные посредники.
 *
 * @package App.Http.Middleware
 * @version 1.0
 * @since 1.0
 */

namespace App\Http\Middleware;

use App;
use Closure;
use Illuminate\Http\Request;

/**
 * Класс посредник для установки локалей.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Locale
{
    /**
     * Установка локалей.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @param \Closure $next Функция последющего действия.
     * @param string|null $guard Значение доступа.
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next, $guard = null)
    {
        if($request->get("ln") == "en")
        {
            setlocale(LC_ALL, ['en_US.utf8']);
            setlocale(LC_NUMERIC, ['en_US.utf8']);
        }
        else
        {
            setlocale(LC_ALL, ['ru_RU.utf8', 'rus_RUS.utf8', 'russian']);
            setlocale(LC_NUMERIC, ['ru_RU.utf8']);
        }

        App::setLocale($request->get("ln", "ru"));

        return $next($request);
    }
}
