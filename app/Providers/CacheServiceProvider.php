<?php
/**
 * Основные провайдеры.
 *
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */

namespace app\Providers;

use Cache;
use Illuminate\Support\ServiceProvider;
use App\Models\Caches\CacheMemcache;
use App\Models\Caches\CacheMongoDb;


/**
 * Класс сервис-провайдера для кеширования.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CacheServiceProvider extends ServiceProvider
{
    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot()
    {
        Cache::extend('memcache',
            function()
            {
                return Cache::repository(new CacheMemcache());
            }
        );

        Cache::extend('mongodb',
            function()
            {
                return Cache::repository(new CacheMongoDb());
            }
        );
    }

    /**
     * Регистрация сервис провайдеров.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function register()
    {
        //
    }
}