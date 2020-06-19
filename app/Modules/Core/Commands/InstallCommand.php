<?php
/**
 * Модуль Ядро системы.
 * Этот модуль содержит все классы для работы с ядром системы.
 *
 * @package App\Modules\Core
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Core\Commands;

use Installer;
use Illuminate\Console\Command;

use App\Modules\Core\Pipes\InstallerProtectPipe;
use App\Modules\Core\Pipes\InstallerDatabasePipe;
use App\Modules\Core\Pipes\InstallerMongoDbPipe;
use App\Modules\Core\Pipes\InstallerRedisPipe;
use App\Modules\Core\Pipes\InstallerMailPipe;
use App\Modules\Core\Pipes\InstallerAppKeyPipe;
use App\Modules\Core\Pipes\InstallerMigratorPipe;
use App\Modules\Core\Pipes\InstallerSeederPipe;
use App\Modules\Core\Pipes\InstallerSettingPipe;
use App\Modules\Core\Pipes\InstallerSavePipe;
use App\Modules\Core\Pipes\InstallerFlagPipe;
use App\Modules\Core\Pipes\InstallerCleanCachePipe;
use App\Modules\Core\Pipes\InstallerApiPipe;

/**
 * Класс комманда для установки системы.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class InstallCommand extends Command
{
    /**
     * Название консольной комманды.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    protected $signature = 'weborobot:install';

    /**
     * Описание консольной комманды.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    protected $description = 'Install the system.';

    /**
     * Выполнение комманды.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function handle()
    {
        Installer::setCommand($this)->setActions([
            InstallerProtectPipe::class,
            InstallerDatabasePipe::class,
            InstallerMongoDbPipe::class,
            InstallerRedisPipe::class,
            InstallerMailPipe::class,
            InstallerSettingPipe::class,
            InstallerMigratorPipe::class,
            InstallerSeederPipe::class,
            InstallerAppKeyPipe::class,
            InstallerFlagPipe::class,
            InstallerSavePipe::class,
            InstallerCleanCachePipe::class,
            InstallerApiPipe::class
        ])->run();
    }
}
