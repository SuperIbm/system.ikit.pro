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
use Geocoder;
use Illuminate\Support\ServiceProvider;
use App\Models\Geocoder\GeocoderManager;
use App\Models\Geocoder\GeocoderGoogle;


/**
 * Класс сервис-провайдера для геокодирования.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class GeocoderServiceProvider extends ServiceProvider
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
        App::singleton('geocoder',
            function($app)
            {
                return new GeocoderManager($app);
            }
        );

        Geocoder::extend('google',
            function()
            {
                return new GeocoderGoogle();
            }
        );
    }
}