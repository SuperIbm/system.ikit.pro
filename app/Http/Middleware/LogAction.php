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
use Log;
use Illuminate\Http\Request;

/**
 * Класс посредник для записей медленных действий.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class LogAction
{
    /**
     * Запись в лог всех медленных действий.
     *
     * @param \Illuminate\Http\Request $request Запрос.
     * @param \Closure $next Функция последющего действия.
     *
     * @return mixed Вернет результат продолжение запроса.
     */
    public function handle(Request $request, Closure $next)
    {
        $next($request);

        /*
        if(function_exists('getrusage')) $usage = getrusage();
        else $usage = [];

        $executeTimeStart = microtime(true);
        $executeMemoryStart = memory_get_usage();

        if(function_exists('getrusage')) $executeCpuStart = $usage["ru_utime.tv_sec"] * 1e6 + $usage["ru_utime.tv_usec"];
        else $executeCpuStart = 0;

        $response = $next($request);

        if(function_exists('getrusage')) $usage = getrusage();

        $executeTimeEnd = microtime(true);
        $executeMemoryEnd = memory_get_usage();

        if(function_exists('getrusage')) $executeCpuEnd = $usage["ru_utime.tv_sec"] * 1e6 + $usage["ru_utime.tv_usec"];
        else $executeCpuEnd = 0;

        $executeTime = $executeTimeEnd - $executeTimeStart;
        $executeMemory = $executeMemoryEnd - $executeMemoryStart;

        if(function_exists('getrusage'))
        {
            $executeCpu = $executeCpuEnd - $executeCpuStart;
            $cpu = ($executeCpu / ($executeTime * 1000000) * 100);
        }
        else $cpu = 0;

        $executeMemory = $executeMemory / 1048576;

        if
        (
            config('app.log_slow_time', 0) == 0 ||
            config('app.log_slow_memory', 0) == 0 ||
            config('app.log_slow_cpu', 0) == 0 ||
            $executeTime > config('app.log_slow_time') ||
            $executeMemory > config('app.log_slow_memory') ||
            $cpu > config('app.log_slow_cpu')
        )
        {
            Log::alert($request->fullUrl(),
                [
                    "time" => $executeTime,
                    "memory" => $executeMemory,
                    "cpu" => $cpu,
                    "type" => "execute"
                ]
            );
        }

        return $response;*/
    }
}
