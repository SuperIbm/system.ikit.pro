<?php
/**
 * Модуль Пользователи.
 * Этот модуль содержит все классы для работы с пользователями, авторизации и аунтификации в системе.
 *
 * @package App\Modules\User
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\User\Providers;

use App;
use App\Modules\User\Repositories\UserVerification;
use Illuminate\Support\ServiceProvider;

use App\Modules\User\Models\BlockIp as BlockIpModel;
use App\Modules\User\Repositories\BlockIp as BlockIpRepository;

use App\Modules\User\Models\User as UserModel;
use App\Modules\User\Repositories\User as UserRepository;
use App\Modules\User\Events\Listeners\UserListener;

use App\Modules\User\Models\UserAddress as UserAddressModel;
use App\Modules\User\Repositories\UserAddress as UserAddressRepository;

use App\Modules\User\Models\UserSchool as UserSchoolModel;
use App\Modules\User\Repositories\UserSchool as UserSchoolRepository;

use App\Modules\User\Models\UserAuth as UserAuthModel;
use App\Modules\User\Repositories\UserAuth as UserAuthRepository;

use App\Modules\User\Models\UserSchoolRole as UserSchoolRoleModel;
use App\Modules\User\Repositories\UserSchoolRole as UserSchoolRoleRepository;
use App\Modules\User\Events\Listeners\UserSchoolListener;

use App\Modules\User\Models\UserRole as UserRoleModel;
use App\Modules\User\Repositories\UserRole as UserRoleRepository;
use App\Modules\User\Events\Listeners\UserRoleListener;

use App\Modules\User\Models\UserReferral as UserReferralModel;
use App\Modules\User\Repositories\UserReferral as UserReferralRepository;

use App\Modules\User\Models\UserVerification as UserVerificationModel;
use App\Modules\User\Repositories\UserVerification as UserVerificationRepository;

use App\Modules\User\Models\UserRecovery as UserRecoveryModel;
use App\Modules\User\Repositories\UserRecovery as UserRecoveryRepository;

use App\Modules\User\Models\UserWallet as UserWalletModel;
use App\Modules\User\Repositories\UserWallet as UserWalletRepository;
use App\Modules\User\Events\Listeners\UserWalletListener;

use App\Modules\User\Models\UserWalletInput as UserWalletInputModel;
use App\Modules\User\Repositories\UserWalletInput as UserWalletInputRepository;

use App\Modules\User\Models\UserWalletOutput as UserWalletOutputModel;
use App\Modules\User\Repositories\UserWalletOutput as UserWalletOutputRepository;

use Illuminate\Database\Eloquent\Factory;

/**
 * Класс сервис-провайдера для настройки этого модуля.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class UserServiceProvider extends ServiceProvider
{
    /**
     * Название модуля.
     *
     * @var string $moduleName
     */
    protected string $moduleName = 'User';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected string $moduleNameLower = 'user';

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @version 1.0
     * @since 1.0
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
     * @version 1.0
     * @since 1.0
     */
    public function register(): void
    {
        $this->app->register(RouteServiceProvider::class);

        App::singleton(BlockIpRepository::class, function() {
            return new BlockIpRepository(new BlockIpModel());
        });

        //

        App::singleton(UserRepository::class, function() {
            return new UserRepository(new UserModel());
        });

        UserModel::observe(UserListener::class);

        //

        App::singleton(UserAddressRepository::class, function() {
            return new UserAddressRepository(new UserAddressModel());
        });

        //

        App::singleton(UserSchoolRepository::class, function() {
            return new UserSchoolRepository(new UserSchoolModel());
        });

        UserSchoolModel::observe(UserSchoolListener::class);

        //

        App::singleton(UserAuthRepository::class, function() {
            return new UserAuthRepository(new UserAuthModel());
        });

        //

        App::singleton(UserSchoolRoleRepository::class, function() {
            return new UserSchoolRoleRepository(new UserSchoolRoleModel());
        });

        //

        App::singleton(UserRoleRepository::class, function() {
            return new UserRoleRepository(new UserRoleModel());
        });

        UserRoleModel::observe(UserRoleListener::class);

        //

        App::singleton(UserReferralRepository::class, function() {
            return new UserReferralRepository(new UserReferralModel());
        });

        //

        App::singleton(UserVerificationRepository::class, function() {
            return new UserVerificationRepository(new UserVerificationModel());
        });

        //

        App::singleton(UserRecoveryRepository::class, function() {
            return new UserRecoveryRepository(new UserRecoveryModel());
        });

        //

        App::singleton(UserWalletRepository::class, function() {
            return new UserWalletRepository(new UserWalletModel());
        });

        UserWalletModel::observe(UserWalletListener::class);

        //

        App::singleton(UserWalletInputRepository::class, function() {
            return new UserWalletInputRepository(new UserWalletInputModel());
        });

        //

        App::singleton(UserWalletOutputRepository::class, function() {
            return new UserWalletOutputRepository(new UserWalletOutputModel());
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
