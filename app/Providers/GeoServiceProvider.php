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
use Geo;
use Illuminate\Support\ServiceProvider;
use App\Models\Geo\GeoManager;
use App\Models\Geo\GeoBase;


/**
 * Класс сервис-провайдера для геопозиционирования.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeoServiceProvider extends ServiceProvider
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
        App::singleton('geo',
            function($app)
            {
                return new GeoManager($app);
            }
        );

        Geo::extend('base',
            function()
            {
                return new GeoBase();
            }
        );
    }
}