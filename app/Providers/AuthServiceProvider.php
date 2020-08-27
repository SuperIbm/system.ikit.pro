<?php
/**
 * Основные провайдеры.
 *
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
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * Список политки.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Обработчик события загрузки приложения.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate Проверка права.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies();

        Auth::provider('access', function($app) {
            return new AccessUserProvider($app->make('App\Modules\User\Repositories\User'), $app->make('App\Modules\User\Repositories\BlockIp'));
        });

        $gate->define('section', 'App\Modules\Access\Models\GateSection@check');
        $gate->define('role', 'App\Modules\Access\Models\GateRole@check');
        $gate->define('user', 'App\Modules\Access\Models\GateUser@check');
        $gate->define('school', 'App\Modules\Access\Models\GateSchool@check');
        $gate->define('limit', 'App\Modules\Access\Models\GateLimit@check');
        $gate->define('paid', 'App\Modules\Access\Models\GatePaid@check');
        $gate->define('trial', 'App\Modules\Access\Models\GateTrial@check');
        $gate->define('verified', 'App\Modules\Access\Models\GateVerified@check');
    }
}
