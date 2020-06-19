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
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('oauth.php'),
        ], 'config');
        $this->mergeConfigFrom(__DIR__ . '/../Config/config.php', 'oauth');
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/oauth');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function($path)
        {
            return $path . '/modules/oauth';
        }, \Config::get('view.paths')), [$sourcePath]), 'oauth');
    }

    /**
     * Регистрация локалей.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/oauth');

        if(is_dir($langPath))
        {
            $this->loadTranslationsFrom($langPath, 'oauth');
        }
        else
        {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'oauth');
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
