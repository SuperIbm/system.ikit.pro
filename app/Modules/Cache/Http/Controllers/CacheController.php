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

use Illuminate\Routing\Controller;
use Cache;
use Log;
use Auth;
use Artisan;
use Storage;

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
    public function clean()
    {
        Log::info('Cache is deleted.', [
            "login" => Auth::user()->login,
            "module" => "Cache",
            'type' => 'destroy'
        ]);

        Cache::flush();

        Artisan::call("view:clear");
        Artisan::call("config:cache");

        $files = Storage::disk('pages')->allFiles();
        Storage::delete($files);

        return response()->json([
            'success' => true,
            'message' => "We've cleaned all the cache."
        ]);
    }
}
