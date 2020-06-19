<?php
/**
 * Основные провайдеры.
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */
namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Auth;
use App\Modules\Access\Models\AccessUserProvider;
use Laravel\Passport\Passport;
use Carbon\Carbon;

/**
 * Класс сервис-провайдера для авторизации.
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Список политки.
     * @var array
     */
    protected $policies =
        [
            //'App\Model' => 'App\Policies\ModelPolicy',
        ];

    /**
     * Обработчик события загрузки приложения.
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate Проверка права.
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        Auth::provider('access', function($app)
            {
                return new AccessUserProvider($app->make('App\Modules\User\Repositories\User'), $app->make('App\Modules\User\Repositories\BlockIp'));
            }
        );

        $gate->define('section', 'App\Modules\Access\Models\GateSection@check');
        $gate->define('page', 'App\Modules\Access\Models\GatePage@check');
        $gate->define('pageUpdate', 'App\Modules\Access\Models\GatePageUpdate@check');
        $gate->define('role', 'App\Modules\Access\Models\GateRole@check');
        $gate->define('group', 'App\Modules\Access\Models\GateGroup@check');
        $gate->define('admin', 'App\Modules\Access\Models\GateAdmin@check');
        $gate->define('user', 'App\Modules\Access\Models\GateUser@check');
    }
}
