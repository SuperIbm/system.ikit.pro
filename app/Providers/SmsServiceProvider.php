<?php
/**
 * Основные провайдеры.
 *
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */

namespace app\Providers;

use App;
use Sms;
use Illuminate\Support\ServiceProvider;
use App\Models\Sms\SmsManager;
use App\Models\Sms\SmsCenter;
use App\Models\Sms\SmsNexmo;
use App\Models\Sms\SmsLog;

/**
 * Класс сервис-провайдера для смс.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class SmsServiceProvider extends ServiceProvider
{
    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot()
    {
        App::singleton('sms', function($app) {
            return new SmsManager($app);
        });

        Sms::extend('center', function() {
            return new SmsCenter();
        });

        Sms::extend('nexmo', function() {
            return new SmsNexmo();
        });

        Sms::extend('log', function() {
            return new SmsLog();
        });
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
        //
    }
}