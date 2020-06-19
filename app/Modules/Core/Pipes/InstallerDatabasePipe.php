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
 * Запуск установки конфигурации базы данных.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerDatabasePipe implements Pipe
{
    /**
     * Метод который будет вызван у pipeline.
     *
     * @param array $content Содержит массив свойсв, которые можно передавать от pipe к pipe.
     * @param Closure $next Ссылка на следующий pipe.
     *
     * @return mixed Вернет значение полученное после выполнения следующего pipe.
     * @since 1.0
     * @version 1.0
     */
    public function handle($content, Closure $next)
    {
        $connected = false;

        $data = [
            'DB_CONNECTION' => 'mysql',
            'DB_MYSQL_HOST' => '',
            'DB_MYSQL_PORT' => 3306,
            'DB_MYSQL_DATABASE' => '',
            'DB_MYSQL_USERNAME' => '',
            'DB_MYSQL_PASSWORD' => ''
        ];

        /**
         * @var $command \Illuminate\Console\Command
         */
        $command = $content["command"];

        while(!$connected)
        {
            $data['DB_MYSQL_HOST'] = $command->ask('Enter your database host', 'localhost');
            $data['DB_MYSQL_DATABASE'] = $command->ask('Enter your database name', 'weborobot');
            $data['DB_MYSQL_USERNAME'] = $command->ask('Enter your database username', 'root');
            $data['DB_MYSQL_PASSWORD'] = $command->ask('Enter your database password', '');

            if($data['DB_MYSQL_PASSWORD'] == "NULL") $data['DB_MYSQL_PASSWORD'] = null;

            Config::set('database.connections.mysql.host', $data['DB_MYSQL_HOST']);
            Config::set('database.connections.mysql.database', $data['DB_MYSQL_DATABASE']);
            Config::set('database.connections.mysql.username', $data['DB_MYSQL_USERNAME']);
            Config::set('database.connections.mysql.password', $data['DB_MYSQL_PASSWORD']);

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

        $content["result"] = array_merge($content["result"], $data);
        return $next($content);
    }
}
