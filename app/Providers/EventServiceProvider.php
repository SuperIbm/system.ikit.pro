<?php
/**
 * Основные провайдеры.
 *
 * @package App.Providers
 * @version 1.0
 * @since 1.0
 */

namespace App\Providers;

use Config;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use DB;
use Log;

/**
 * Класс сервис-провайдера для событий.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * Список событий для приложения.
     *
     * @var array
     */
    protected $listen = [];

    /**
     * Обработчик события загрузки приложения.
     *
     * @return void
     * @version 1.0
     * @since 1.0
     */
    public function boot()
    {
        parent::boot();

        if(Config::get('database.log', false))
        {
            DB::listen(function($query) {
                if(($query->time / 1000) >= Config::get('database.timeSlow', 0))
                {
                    $data = [
                        "bindings" => $query->bindings,
                        "time" => $query->time / 1000,
                        "sql" => $query->sql,
                    ];

                    foreach($query->bindings as $i => $binding)
                    {
                        if($binding instanceof \DateTime) $bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
                        else if(is_string($binding)) $bindings[$i] = "'$binding'";
                    }

                    $query = str_replace(array('%', '?'), array('%%', '%s'), $query->sql);
                    $query = vsprintf($query, $query->bindings);

                    $data["type"] = "base";

                    if(Config::get('database.timeSlow', 0) != 0) Log::warning($query, $data);
                    else Log::info($query, $data);
                }
            });
        }
    }
}
