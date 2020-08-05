<?php
/**
 * Модуль API аутентификации.
 * Этот модуль содержит все классы для работы с API аутентификации.
 *
 * @package App\Modules\OAuth
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\OAuth\Providers;

use App;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;

use App\Modules\User\Repositories\User;

use App\Modules\OAuth\Models\OAuthClientEloquent as ModelOAuthClientEloquent;
use App\Modules\OAuth\Repositories\OAuthClientEloquent as RepositoryOAuthClientEloquent;
use App\Modules\OAuth\Events\Listeners\OAuthClientEloquentListener;

use App\Modules\OAuth\Models\OAuthTokenEloquent as ModelOAuthTokenEloquent;
use App\Modules\OAuth\Repositories\OAuthTokenEloquent as RepositoryOAuthTokenEloquent;
use App\Modules\OAuth\Events\Listeners\OAuthTokenEloquentListener;

use App\Modules\OAuth\Models\OAuthRefreshTokenEloquent as ModelOAuthRefreshTokenEloquent;
use App\Modules\OAuth\Repositories\OAuthRefreshTokenEloquent as RepositoryOAuthRefreshTokenEloquent;

use App\Modules\OAuth\Models\OAuthDriverManager;
use App\Modules\OAuth\Models\OAuthDriverDatabase;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class OAuthServiceProvider extends ServiceProvider
{
    /**
     * Название модуля.
     *
     * @var string $moduleName
     */
    protected string $moduleName = 'OAuth';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'oauth';

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

        App::singleton(RepositoryOAuthClientEloquent::class, function()
        {
            return new RepositoryOAuthClientEloquent(new ModelOAuthClientEloquent());
        });

        ModelOAuthClientEloquent::observe(OAuthClientEloquentListener::class);

        //

        App::singleton(RepositoryOAuthTokenEloquent::class, function()
        {
            return new RepositoryOAuthTokenEloquent(new ModelOAuthTokenEloquent());
        });

        ModelOAuthTokenEloquent::observe(OAuthTokenEloquentListener::class);

        //

        App::singleton(RepositoryOAuthRefreshTokenEloquent::class, function()
        {
            return new RepositoryOAuthRefreshTokenEloquent(new ModelOAuthRefreshTokenEloquent());
        });

        //

        App::singleton('oauth',
            function($app)
            {
                return new OAuthDriverManager($app);
            }
        );

        App::make('oauth')->extend('database',
            function()
            {
                return new OAuthDriverDatabase(app(User::class), app(RepositoryOAuthClientEloquent::class), app(RepositoryOAuthTokenEloquent::class), app(RepositoryOAuthRefreshTokenEloquent::class));
            }
        );
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
