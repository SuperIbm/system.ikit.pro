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

use DB;
use Config;
use App\Models\Contracts\Pipe;
use PDOException;
use Closure;

/**
 * Запуск установки конфигурации базы данных MongoDb.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerMongoDbPipe implements Pipe
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
            'DB_MONGODB_HOST' => '',
            'DB_MONGODB_PORT' => '',
            'DB_MONGODB_DATABASE' => '',
            'DB_MONGODB_USERNAME' => '',
            'DB_MONGODB_PASSWORD' => ''
        ];

        /**
         * @var $command \Illuminate\Console\Command
         */
        $command = $content["command"];

        if($command->confirm('Would you like setting MongoDB for your system? [Y|N]', false))
        {
            while(!$connected)
            {
                $data['DB_MONGODB_HOST'] = $command->ask('Enter your database host', 'localhost');
                $data['DB_MONGODB_PORT'] = $command->ask('Enter your port', '27017');
                $data['DB_MONGODB_DATABASE'] = $command->ask('Enter your database name', 'weborobot');
                $data['DB_MONGODB_USERNAME'] = $command->ask('Enter your database username', 'root');
                $data['DB_MONGODB_PASSWORD'] = $command->ask('Enter your database password', '');

                if($data['DB_MONGODB_PASSWORD'] == "NULL") $data['DB_MONGODB_PASSWORD'] = null;

                Config::set('database.connections.mongodb.host', $data['DB_MONGODB_HOST']);
                Config::set('database.connections.mongodb.port', $data['DB_MONGODB_PORT']);
                Config::set('database.connections.mongodb.database', $data['DB_MONGODB_DATABASE']);
                Config::set('database.connections.mongodb.username', $data['DB_MONGODB_USERNAME']);
                Config::set('database.connections.mongodb.password', $data['DB_MONGODB_PASSWORD']);

                try
                {
                    DB::reconnect();
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
