<?php
/**
 * Модуль Школ.
 * Этот модуль содержит все классы для работы школами.
 *
 * @package App\Modules\School
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\School\Providers;

use App;
use App\Modules\School\Models\Implement as Implement;

use App\Modules\School\Models\School as SchoolModel;
use App\Modules\School\Repositories\School as SchoolRepository;
use App\Modules\School\Events\Listeners\SchoolListener;

use App\Modules\School\Models\SchoolRole as SchoolRoleModel;
use App\Modules\School\Repositories\SchoolRole as SchoolRoleRepository;
use App\Modules\School\Events\Listeners\SchoolRoleListener;

use App\Modules\School\Models\SchoolRoleSection as SchoolRoleSectionModel;
use App\Modules\School\Repositories\SchoolRoleSection as SchoolRoleSectionRepository;

use App\Modules\School\Models\SchoolLimit as SchoolLimitModel;
use App\Modules\School\Repositories\SchoolLimit as SchoolLimitRepository;

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
class SchoolServiceProvider extends ServiceProvider
{
    /**
     * Название модуля.
     *
     * @var string $moduleName
     */
    protected string $moduleName = 'School';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'school';

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
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
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        App::bind('school', function()
        {
            return app(Implement::class);
        });

        //

        App::singleton(SchoolRepository::class, function()
        {
            return new SchoolRepository(new SchoolModel());
        });

        SchoolModel::observe(SchoolListener::class);

        //

        App::singleton(SchoolRoleRepository::class, function()
        {
            return new SchoolRoleRepository(new SchoolRoleModel());
        });

        SchoolRoleModel::observe(SchoolRoleListener::class);

        //

        App::singleton(SchoolRoleSectionRepository::class, function()
        {
            return new SchoolRoleSectionRepository(new SchoolRoleSectionModel());
        });

        //

        App::singleton(SchoolLimitRepository::class, function()
        {
            return new SchoolLimitRepository(new SchoolLimitModel());
        });
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
