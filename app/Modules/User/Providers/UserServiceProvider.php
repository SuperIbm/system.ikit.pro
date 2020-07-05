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
use Validator;
use Illuminate\Support\ServiceProvider;

use App\Modules\User\Models\BlockIp as BlockIpModel;
use App\Modules\User\Repositories\BlockIp as BlockIpRepository;

use App\Modules\User\Models\User as UserModel;
use App\Modules\User\Repositories\User as UserRepository;
use App\Modules\User\Events\Listeners\UserListener;

use App\Modules\User\Models\UserGroup as UserGroupModel;
use App\Modules\User\Repositories\UserGroup as UserGroupRepository;
use App\Modules\User\Events\Listeners\UserGroupListener;

use App\Modules\User\Models\UserCompany as UserCompanyModel;
use App\Modules\User\Repositories\UserCompany as UserCompanyRepository;

use App\Modules\User\Models\UserAddress as UserAddressModel;
use App\Modules\User\Repositories\UserAddress as UserAddressRepository;

use App\Modules\User\Models\UserGroupUser as UserGroupUserModel;
use App\Modules\User\Repositories\UserGroupUser as UserGroupUserRepository;

use App\Modules\User\Models\UserGroupPage as UserGroupPageModel;
use App\Modules\User\Repositories\UserGroupPage as UserGroupPageRepository;

use App\Modules\User\Models\UserGroupRole as UserGroupRoleModel;
use App\Modules\User\Repositories\UserGroupRole as UserGroupRoleRepository;

use App\Modules\User\Models\UserRole as UserRoleModel;
use App\Modules\User\Repositories\UserRole as UserRoleRepository;
use App\Modules\User\Events\Listeners\UserRoleListener;

use App\Modules\User\Models\UserRoleAdminSection as UserRoleAdminSectionModel;
use App\Modules\User\Repositories\UserRoleAdminSection as UserRoleAdminSectionRepository;

use App\Modules\User\Models\UserVerification as UserVerificationModel;
use App\Modules\User\Repositories\UserVerification as UserVerificationRepository;

use App\Modules\User\Models\UserRecovery as UserRecoveryModel;
use App\Modules\User\Repositories\UserRecovery as UserRecoveryRepository;

use App\Modules\User\Models\UserRolePage as UserRolePageModel;
use App\Modules\User\Repositories\UserRolePage as UserRolePageRepository;
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
    protected $moduleName = 'User';

    /**
     * Название модуля в нижнем регисте.
     *
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'user';

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @version 1.0
     * @since 1.0
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
     * @version 1.0
     * @since 1.0
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        App::singleton(BlockIpRepository::class, function() {
            return new BlockIpRepository(new BlockIpModel());
        });

        App::singleton(UserRepository::class, function() {
            return new UserRepository(new UserModel());
        });

        UserModel::observe(UserListener::class);

        App::singleton(UserGroupRepository::class, function() {
            return new UserGroupRepository(new UserGroupModel());
        });

        UserModel::observe(UserGroupListener::class);

        App::singleton(UserCompanyRepository::class, function() {
            return new UserCompanyRepository(new UserCompanyModel());
        });

        App::singleton(UserAddressRepository::class, function() {
            return new UserAddressRepository(new UserAddressModel());
        });

        App::singleton(UserGroupUserRepository::class, function() {
            return new UserGroupUserRepository(new UserGroupUserModel());
        });

        App::singleton(UserGroupPageRepository::class, function() {
            return new UserGroupPageRepository(new UserGroupPageModel());
        });

        App::singleton(UserGroupRoleRepository::class, function() {
            return new UserGroupRoleRepository(new UserGroupRoleModel());
        });

        App::singleton(UserRoleRepository::class, function() {
            return new UserRoleRepository(new UserRoleModel());
        });

        UserRoleModel::observe(UserRoleListener::class);

        App::singleton(UserRoleAdminSectionRepository::class, function() {
            return new UserRoleAdminSectionRepository(new UserRoleAdminSectionModel());
        });

        App::singleton(UserRolePageRepository::class, function() {
            return new UserRolePageRepository(new UserRolePageModel());
        });

        App::singleton(UserVerificationRepository::class, function() {
            return new UserVerificationRepository(new UserVerificationModel());
        });

        App::singleton(UserRecoveryRepository::class, function() {
            return new UserRecoveryRepository(new UserRecoveryModel());
        });
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
