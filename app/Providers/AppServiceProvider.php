<?php
/**
 * Основные провайдеры.
 *
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use DB;
use Config;
use App\Models\Util;
use App\Models\Bot;

use Illuminate\Support\Facades\Schema;

/**
 * Класс сервис-провайдера для всего приложения.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AppServiceProvider extends ServiceProvider
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
        Schema::defaultStringLength(191);
        DB::statement("SET sql_mode = ''");
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
        App::bind('util',
            function()
            {
                return new Util();
            }
        );

        App::bind('bot',
            function()
            {
                return new Bot();
            }
        );
    }
}
