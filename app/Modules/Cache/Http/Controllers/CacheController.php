<?php
/**
 * Модуль Кеширования.
 * Этот модуль содержит все классы для работы с кешированием.
 *
 * @package App\Modules\Cache
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Cache\Http\Controllers;

use Cache;
use Log;
use Auth;
use Artisan;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;

/**
 * Класс контроллер для ядра административной системы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CacheController extends Controller
{
    /**
     * Очитска всех закешированных данных.
     *
     * @return \Illuminate\Http\JsonResponse Верент JSON ответ.
     * @since 1.0
     * @version 1.0
     */
    public function clean(): JsonResponse
    {
        Cache::flush();

        Artisan::call("view:clear");
        Artisan::call("config:cache");

        Log::info(trans('cache::http.controllers.cache.clean.log'), [
            "login" => Auth::user()->login,
            "module" => "Cache",
            'type' => 'destroy'
        ]);

        return response()->json([
            'success' => true,
            'message' => trans('cache::http.controllers.cache.clean.message')
        ]);
    }
}
