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
     * Название модуля.
     *
     * @var string $moduleName
     */
    protected $moduleName = 'Section';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'section';

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function boot(): void
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerFactories();
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Регистрация сервис провайдеров.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function register(): void
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
     */
    protected function registerConfig(): void
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower);
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    public function registerViews(): void
    {
        $viewPath = resource_path('views/modules/' . $this->moduleNameLower);

        $sourcePath = module_path($this->moduleName, 'Resources/views');

        $this->publishes([
            $sourcePath => $viewPath
        ], ['views', $this->moduleNameLower . '-module-views']);

        $this->loadViewsFrom(array_merge($this->getPublishableViewPaths(), [$sourcePath]), $this->moduleNameLower);
    }

    /**
     * Регистрация локалей.
     *
     * @return void
     */
    public function registerTranslations(): void
    {
        $langPath = resource_path('lang/modules/' . $this->moduleNameLower);

        if(is_dir($langPath))
        {
            $this->loadTranslationsFrom($langPath, $this->moduleNameLower);
        }
        else
        {
            $this->loadTranslationsFrom(module_path($this->moduleName, 'Resources/lang'), $this->moduleNameLower);
        }
    }

    /**
     * Регистрация дополнительной директории для фабрик.
     *
     * @return void
     */
    public function registerFactories(): void
    {
        if(!app()->environment('production') && $this->app->runningInConsole())
        {
            app(Factory::class)->load(module_path($this->moduleName, 'Database/factories'));
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

    /**
     * Получить пути к опубликованным шаблонам.
     *
     * @return array
     */
    private function getPublishableViewPaths(): array
    {
        $paths = [];
        foreach(\Config::get('view.paths') as $path)
        {
            if(is_dir($path . '/modules/' . $this->moduleNameLower))
            {
                $paths[] = $path . '/modules/' . $this->moduleNameLower;
            }
        }
        return $paths;
    }
}
