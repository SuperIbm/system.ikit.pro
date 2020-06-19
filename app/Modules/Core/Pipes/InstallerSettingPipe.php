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

use App\Models\Contracts\Pipe;
use Closure;

/**
 * Запуск установки дополнительных настроек системы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallerSettingPipe implements Pipe
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
        /**
         * @var $command \Illuminate\Console\Command
         */
        $command = $content["command"];

        $data = [
            'APP_SITE_RECONSTRUCTION' => false,
            'APP_NAME' => 'Weborobot',
            'COMPANY_NAME' => '',
            'APP_ENV' => 'local',
            'APP_DEBUG' => true,
            'APP_URL' => 'http://localhost',
            'APP_TIMEZONE' => 'America/Toronto',
            'APP_LOCALE' => 'ru',

            'LOG_CHANNEL' => 'stack',

            'APP_CSS' => 'css/main.css',

            'CACHE_DRIVER' => 'redis',
            'QUEUE_CONNECTION' => 'database',
            'SESSION_DRIVER' => 'database',

            'IMAGE' => 'database',
            'IMAGE_DRIVER' => 'local',

            'DOCUMENT' => 'database',
            'DOCUMENT_DRIVER' => 'local',

            'OAUTH_DRIVER' => 'base',

            'SEO_DRIVER' => 'database'
        ];

        if($command->confirm('Would you like entering additional settings? [Y|N]', false))
        {
            $data['APP_SITE_RECONSTRUCTION'] = $command->confirm('Is your site in reconstraction? [Y|N]', $data['APP_SITE_RECONSTRUCTION']);
            $data['APP_NAME'] = $command->ask('Enter your site name', $data['APP_NAME']);
            $data['COMPANY_NAME'] = $command->ask('Enter your company name', $data['COMPANY_NAME']);
            $data['APP_ENV'] = $command->ask('Enter your environment', $data['APP_ENV']);
            $data['APP_DEBUG'] = $command->ask('Enable error display?', $data['APP_DEBUG']);
            $data['APP_URL'] = $command->ask('Enter an url of your site', $data['APP_URL']);
            $data['APP_TIMEZONE'] = $command->ask('Enter a timezone for your site', $data['APP_TIMEZONE']);
            $data['APP_LOCALE'] = $command->ask('Enter your locale', $data['APP_LOCALE']);

            $data['APP_CSS'] = $command->ask('Enter a path to your main css file', $data['APP_CSS']);

            $data['CACHE_DRIVER'] = $command->choice('Where do you want to prefer storing your cache?', [
                'apc',
                'array',
                'database',
                'file',
                'memcached',
                'redis',
                'memcache',
                'mongodb'
            ], 6);

            $data['QUEUE_CONNECTION'] = $command->choice('Would you like using a queue driver?', [
                'sync',
                'database',
                'beanstalkd',
                'sqs',
                'redis'
            ], 1);

            $data['SESSION_DRIVER'] = $command->choice('Where do you want to prefer storing your session?', [
                'file',
                'cookie',
                'database',
                'apc',
                'memcached',
                'redis',
                'array',
                'memcache'
            ], 2);

            $data['IMAGE'] = $command->choice('Where do you want to prefer storing your records for your images?', [
                'database',
                'mongodb'
            ], 0);

            $data['IMAGE_DRIVER'] = $command->choice('Where do you want to prefer storing your images?', [
                'local',
                'base',
                'ftp',
                'http'
            ], 0);

            $data['DOCUMENT'] = $command->choice('Where do you want to prefer storing your records for your documents?', [
                'database',
                'mongodb'
            ], 0);

            $data['DOCUMENT_DRIVER'] = $command->choice('Where do you want to prefer storing your documents?', [
                'local',
                'base',
                'ftp',
                'http'
            ], 0);

            $data['OAUTH_DRIVER'] = $command->choice('Where do you want to prefer storing your data for tokens?', [
                'database'
            ], 0);

            $data['SEO_DRIVER'] = $command->choice('Where do you want to prefer storing your data for SEO?', [
                'database',
                'mongodb'
            ], 0);
        }

        $content["result"] = array_merge($content["result"], $data);
        return $next($content);
    }
}
