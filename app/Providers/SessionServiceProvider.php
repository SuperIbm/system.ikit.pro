<?php
/**
 * Основные провайдеры.
 *
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */

namespace app\Providers;

use Session;
use Illuminate\Support\ServiceProvider;
use App\Models\Sessions\SessionMemcache;

/**
 * Класс сервис-провайдера для сессий.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SessionServiceProvider extends ServiceProvider
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
        Session::extend('memcache', function() {
            return new SessionMemcache();
        });
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