<?php
/**
 * Модуль Разделы системы.
 * Этот модуль содержит все классы для работы с разделами системы.
 *
 * @package App\Modules\Section
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Section\Providers;

use App;
use Illuminate\Support\ServiceProvider;

use App\Modules\Section\Models\Section as SectionModel;
use App\Modules\Section\Repositories\Section as SectionRepository;

use App\Modules\Section\Events\Listeners\SectionListener;
use Illuminate\Database\Eloquent\Factory;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SectionServiceProvider extends ServiceProvider
{
    /**
     * Индификатор отложенной загрузки.
     *
     * @var bool
     * @since 1.0
     * @version 1.0
     */
    protected $defer = false;

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @since 1.0
     * @version 1.0
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
     * @since 1.0
     * @version 1.0
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        App::singleton(SectionRepository::class, function()
        {
            return new SectionRepository(new SectionModel());
        });

        SectionModel::observe(SectionListener::class);
    }

    /**
     * Регистрация настроек.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('section.php'),
        ]);
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'section');
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/section');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function($path)
        {
            return $path . '/modules/section';
        }, \Config::get('view.paths')), [$sourcePath]), 'section');
    }

    /**
     * Регистрация локалей.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/section');

        if(is_dir($langPath))
        {
            $this->loadTranslationsFrom($langPath, 'section');
        }
        else
        {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'section');
        }
    }

    /**
     * Регистрация дополнительной директории для фабрик.
     *
     * @return void
     */
    public function registerFactories()
    {
        if(!app()->environment('production'))
        {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Получение сервисов через сервис-провайдер.
     *
     * @return array
     * @since 1.0
     * @version 1.0
     */
    public function provides()
    {
        return [];
    }
}
