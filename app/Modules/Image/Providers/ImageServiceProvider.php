<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use ImageStore;

use App\Modules\Image\Models\ImageEloquent as ImageEloquentModel;
use App\Modules\Image\Repositories\ImageEloquent;

use App\Modules\Image\Models\ImageMongoDb as ImageMongoDbModel;
use App\Modules\Image\Repositories\ImageMongoDb;

use App\Modules\Image\Events\Listeners\ImageListener;

use App\Modules\Image\Models\ImageManager;

use App\Modules\Image\Models\ImageDriverManager;
use App\Modules\Image\Models\ImageDriverBase;
use App\Modules\Image\Models\ImageDriverFtp;
use App\Modules\Image\Models\ImageDriverHttp;
use App\Modules\Image\Models\ImageDriverLocal;

use Illuminate\Database\Eloquent\Factory;
use \App\Modules\Image\Commands\ImageMigrateCommand;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageServiceProvider extends ServiceProvider
{
    /**
     * Название модуля.
     *
     * @var string $moduleName
     */
    protected $moduleName = 'Image';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'image';

    /**
     * Регистрация сервис провайдеров.
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
     * Регистрация настроек.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->commands
        (
            [
                ImageMigrateCommand::class,
            ]
        );

        App::singleton('image.store',
            function($app)
            {
                return new ImageManager($app);
            }
        );

        ImageStore::extend('database',
            function()
            {
                return new ImageEloquent(new ImageEloquentModel());
            }
        );

        ImageEloquentModel::observe(ImageListener::class);

        ImageStore::extend('mongodb',
            function()
            {
                return new ImageMongoDb(new ImageMongoDbModel());
            }
        );

        ImageMongoDbModel::observe(ImageListener::class);

        App::singleton('image.store.driver',
            function($app)
            {
                return new ImageDriverManager($app);
            }
        );

        App::make('image.store.driver')->extend('base',
            function()
            {
                return new ImageDriverBase();
            }
        );

        App::make('image.store.driver')->extend('ftp',
            function()
            {
                return new ImageDriverFtp();
            }
        );

        App::make('image.store.driver')->extend('local',
            function()
            {
                return new ImageDriverLocal();
            }
        );

        App::make('image.store.driver')->extend('http',
            function()
            {
                return new ImageDriverHttp();
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
