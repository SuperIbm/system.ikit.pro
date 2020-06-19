<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessServiceProvider extends ServiceProvider
{
    /**
     * Индификатор отложенной загрузки.
     *
     * @var bool
     * @version 1.0
     * @since 1.0
     */
    protected $defer = false;

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Регистрация настроек.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('access.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'access'
        );
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/access');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function($path)
        {
            return $path . '/modules/access';
        }, \Config::get('view.paths')), [$sourcePath]), 'access');
    }

    /**
     * Регистрация локалей.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/access');

        if(is_dir($langPath))
        {
            $this->loadTranslationsFrom($langPath, 'access');
        }
        else
        {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'access');
        }
    }

    /**
     * Регистрация дополнительной директории для фабрик.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Получение сервисов через сервис-провайдер.
     *
     * @return array
     * @version 1.0
     * @since 1.0
     */
    public function provides()
    {
        return [];
    }
}
