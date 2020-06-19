<?php
/**
 * Модуль предупреждений.
 * Этот модуль содержит все классы для работы с предупреждениями.
 *
 * @package App\Modules\Alert
 * @since 1.0
 * @version 1.0
 */
namespace App\Modules\Alert\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use App;
use App\Modules\Alert\Models\AlertImplement;
use App\Modules\Alert\Models\Alert as AlertModel;
use App\Modules\Alert\Repositories\Alert as AlertRepository;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AlertServiceProvider extends ServiceProvider
{
    /**
     * Индификатор отложенной загрузки.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
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
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        App::singleton(AlertRepository::class, function()
        {
            return new AlertRepository(new AlertModel());
        });

        App::singleton('alert',
            function($app)
            {
                return new AlertImplement($app->make(AlertRepository::class));
            }
        );
    }

    /**
     * Регистрация настроек.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('alert.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'alert'
        );
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/alert');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/alert';
        }, \Config::get('view.paths')), [$sourcePath]), 'alert');
    }

    /**
     * Регистрация локалей.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/alert');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'alert');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'alert');
        }
    }

    /**
     * Регистрация дополнительной директории для фабрик.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production') && $this->app->runningInConsole()) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Получение сервисов через сервис-провайдер.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
