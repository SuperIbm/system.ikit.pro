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
     * Индификатор отложенной загрузки.
     *
     * @var bool
     * @version 1.0
     * @since 1.0
     */
    protected $defer = false;

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
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
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

        Validator::extend('ipMask',
            function($attribute, $value)
            {
                return preg_match('/^(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))\.(([0-9]{1,3})|(\*{1}))$/', $value);
            }
        );

        App::singleton(BlockIpRepository::class,
            function()
            {
                return new BlockIpRepository(new BlockIpModel());
            }
        );

        App::singleton(UserRepository::class,
            function()
            {
                return new UserRepository(new UserModel());
            }
        );

        UserModel::observe(UserListener::class);

        App::singleton(UserGroupRepository::class,
            function()
            {
                return new UserGroupRepository(new UserGroupModel());
            }
        );

        UserModel::observe(UserGroupListener::class);

        App::singleton(UserCompanyRepository::class,
            function()
            {
                return new UserCompanyRepository(new UserCompanyModel());
            }
        );

        App::singleton(UserAddressRepository::class,
            function()
            {
                return new UserAddressRepository(new UserAddressModel());
            }
        );

        App::singleton(UserGroupUserRepository::class,
            function()
            {
                return new UserGroupUserRepository(new UserGroupUserModel());
            }
        );

        App::singleton(UserGroupPageRepository::class,
            function()
            {
                return new UserGroupPageRepository(new UserGroupPageModel());
            }
        );

        App::singleton(UserGroupRoleRepository::class,
            function()
            {
                return new UserGroupRoleRepository(new UserGroupRoleModel());
            }
        );

        App::singleton(UserRoleRepository::class,
            function()
            {
                return new UserRoleRepository(new UserRoleModel());
            }
        );

        UserRoleModel::observe(UserRoleListener::class);

        App::singleton(UserRoleAdminSectionRepository::class,
            function()
            {
                return new UserRoleAdminSectionRepository(new UserRoleAdminSectionModel());
            }
        );

        App::singleton(UserRolePageRepository::class,
            function()
            {
                return new UserRolePageRepository(new UserRolePageModel());
            }
        );

        App::singleton(UserVerificationRepository::class,
            function()
            {
                return new UserVerificationRepository(new UserVerificationModel());
            }
        );

        App::singleton(UserRecoveryRepository::class,
            function()
            {
                return new UserRecoveryRepository(new UserRecoveryModel());
            }
        );
    }

    /**
     * Регистрация настроек.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('user.php'),
        ]);
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'user'
        );
    }

    /**
     * Регистрация представлений.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function registerViews()
    {
        $viewPath = base_path('resources/views/modules/user');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ]);

        $this->loadViewsFrom(array_merge(array_map(function($path)
        {
            return $path . '/modules/user';
        }, \Config::get('view.paths')), [$sourcePath]), 'user');
    }

    /**
     * Регистрация локалей.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function registerTranslations()
    {
        $langPath = base_path('resources/lang/modules/user');

        if(is_dir($langPath))
        {
            $this->loadTranslationsFrom($langPath, 'user');
        }
        else
        {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'user');
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
     * @version 1.0
     * @since 1.0
     */
    public function provides()
    {
        return [];
    }
}
