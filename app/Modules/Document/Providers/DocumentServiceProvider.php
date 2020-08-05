<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use DocumentStore;

use App\Modules\Document\Models\DocumentEloquent as DocumentEloquentModel;
use App\Modules\Document\Repositories\DocumentEloquent;

use App\Modules\Document\Models\DocumentMongoDb as DocumentMongoDbModel;
use App\Modules\Document\Repositories\DocumentMongoDb;

use App\Modules\Document\Events\Listeners\DocumentListener;

use App\Modules\Document\Models\DocumentManager;

use App\Modules\Document\Models\DocumentDriverManager;
use App\Modules\Document\Models\DocumentDriverBase;
use App\Modules\Document\Models\DocumentDriverFtp;
use App\Modules\Document\Models\DocumentDriverHttp;
use App\Modules\Document\Models\DocumentDriverLocal;
use Illuminate\Database\Eloquent\Factory;

use App\Modules\Document\Commands\DocumentMigrateCommand;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentServiceProvider extends ServiceProvider
{
    /**
     * Название модуля.
     *
     * @var string $moduleName
     */
    protected $moduleName = 'Document';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'document';

    /**
     * Регистрация сервис провайдеров.
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
     * Регистрация настроек.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        $this->commands([
            DocumentMigrateCommand::class,
        ]);

        App::singleton('document.store', function($app) {
            return new DocumentManager($app);
        });

        DocumentStore::extend('database', function($app) {
            return new DocumentEloquent(new DocumentEloquentModel());
        });

        DocumentEloquentModel::observe(DocumentListener::class);

        DocumentStore::extend('mongodb', function() {
            return new DocumentMongoDb(new DocumentMongoDbModel());
        });

        DocumentMongoDbModel::observe(DocumentListener::class);

        App::singleton('document.store.driver', function($app) {
            return new DocumentDriverManager($app);
        });

        App::make('document.store.driver')->extend('base', function() {
            return new DocumentDriverBase();
        });

        App::make('document.store.driver')->extend('ftp', function() {
            return new DocumentDriverFtp();
        });

        App::make('document.store.driver')->extend('local', function() {
            return new DocumentDriverLocal();
        });

        App::make('document.store.driver')->extend('http', function() {
            return new DocumentDriverHttp();
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
