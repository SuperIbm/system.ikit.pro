<?php
/**
 * Модуль Кеширования.
 * Этот модуль содержит все классы для работы с кешированием.
 * @package App\Modules\Cache
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Cache\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Класс сервис-провайдера для настройки путей этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Пространство имен модуля, которое предполагается использовать при создании URL-адресов для действий.
     *
     * @var string
     */
    protected $moduleNamespace = 'App\Modules\Cache\Http\Controllers';

    /**
     * Вызвать до того как пути будут зарегистрированы.
     *
     * Зарегистрируйте любые привязки моделей или шаблонные фильтры.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Определяем пути для приложения.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    /**
     * Определяем пути "web" для приложения.
     *
     * Эти пути получают сессии, защиту от крос домен атак и т.д.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Cache', '/Routes/web.php'));
    }

    /**
     * Определяем пути для "API" для приложения.
     *
     * Эти пути ничем не нагружены.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->moduleNamespace)
            ->group(module_path('Cache', '/Routes/api.php'));
    }
}
