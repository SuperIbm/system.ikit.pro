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
use Config;
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
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next)
    {
        $locale = $request->get("locale", Config::get("app.locale"));

        if($locale == "en")
        {
            setlocale(LC_ALL, ['en_US.utf8']);
            setlocale(LC_NUMERIC, ['en_US.utf8']);
        }
        else if($locale == "en")
        {
            setlocale(LC_ALL, ['ru_RU.utf8', 'rus_RUS.utf8', 'russian']);
            setlocale(LC_NUMERIC, ['ru_RU.utf8']);
        }

        App::setLocale($locale);

        return $next($request);
    }
}
