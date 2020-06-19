<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 *
 * @package App\Modules\Core
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Core\Pipes;

use Redis;
use Config;
use App\Models\Contracts\Pipe;
use PDOException;
use Closure;

/**
 * Запуск установки конфигурации базы данных Redis.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerRedisPipe implements Pipe
{
    /**
     * Метод который будет вызван у pipeline.
     *
     * @param array $content Содержит массив свойсв, которые можно передавать от pipe к pipe.
     * @param Closure $next Ссылка на следующий pipe.
     *
     * @return mixed Вернет значение полученное после выполнения следующего pipe.
     */
    public function handle($content, Closure $next)
    {
        $connected = false;

        $data = [
            'REDIS_HOST' => '',
            'REDIS_PORT' => '',
            'REDIS_DATABASE' => '',
            'REDIS_PASSWORD' => '',
            'REDIS_CLUSTER' => ''
        ];

        /**
         * @var $command \Illuminate\Console\Command
         */
        $command = $content["command"];

        if($command->confirm('Would you like setting Redis for your system? [Y|N]', false))
        {
            while(!$connected)
            {
                $data['REDIS_HOST'] = $command->ask('Enter your database host', 'localhost');
                $data['REDIS_PORT'] = $command->ask('Enter your port', '6379');
                $data['REDIS_DATABASE'] = $command->ask('Enter your database name', 0);
                $data['REDIS_PASSWORD'] = $command->ask('Enter your database password', '');

                if($data['REDIS_PASSWORD'] == "NULL") $data['REDIS_PASSWORD'] = null;

                $data['REDIS_CLUSTER'] = $command->confirm('Would you like using cluster system? [Y|N]', false);

                Config::set('database.redis.cluster', $data['REDIS_CLUSTER']);
                Config::set('database.redis.default.host', $data['REDIS_HOST']);
                Config::set('database.redis.default.port', $data['REDIS_PORT']);
                Config::set('database.redis.default.database', $data['REDIS_DATABASE']);
                Config::set('database.redis.default.password', $data['REDIS_PASSWORD']);

                try
                {
                    Redis::connection();
                    $connected = true;
                }
                catch(PDOException $e)
                {
                    $command->error("Please ensure your database credentials are valid.");
                }
            }
        }

        $content["result"] = array_merge($content["result"], $data);
        return $next($content);
    }
}
