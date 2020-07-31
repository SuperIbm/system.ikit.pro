<?php
/**
 * Модуль Рефералов.
 * Этот модуль содержит все классы для работы с рефералами.
 *
 * @package App\Modules\Referral
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Referral\Providers;

use App;
use App\Modules\Referral\Events\Listeners\ReferralListener;
use App\Modules\Referral\Models\Referral as ReferralModel;
use App\Modules\Referral\Repositories\Referral as ReferralRepository;
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
class ReferralServiceProvider extends ServiceProvider
{
    /**
     * Название модуля.
     *
     * @var string $moduleName
     */
    protected $moduleName = 'Referral';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'referral';

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
        $this->loadMigrationsFrom(module_path($this->moduleName, 'Database/Migrations'));
    }

    /**
     * Регистрация сервис провайдеров.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        App::singleton(ReferralRepository::class, function() {
            return new ReferralRepository(new ReferralModel());
        });

        ReferralModel::observe(ReferralListener::class);
    }

    /**
     * Регистрация настроек.
     *
     * @return void
     */
    protected function registerConfig()
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
    public function registerViews()
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
    public function registerTranslations()
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
    public function registerFactories()
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
