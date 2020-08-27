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
use Currency;
use Illuminate\Support\ServiceProvider;
use App\Models\Currency\CurrencyManager;
use App\Models\Currency\CurrencyCbr;


/**
 * Класс сервис-провайдера для валют.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class CurrencyServiceProvider extends ServiceProvider
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
        App::singleton('currency', function($app) {
            return new CurrencyManager($app);
        });

        Currency::extend('cbr', function($app) {
            return new CurrencyCbr();
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