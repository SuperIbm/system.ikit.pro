<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Commands;

use Illuminate\Console\Command;
use ImageStore;
use App;

/**
 * Класс комманда миграции изображений.
 * Позволяет мигрировать изображениям из одного драйвера хранения в другой.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageMigrateCommand extends Command
{
    /**
     * Название консольной комманды.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    protected $signature = 'weborobot:image-migrate {from : Current driver} {to : Another driver}';

    /**
     * Описание консольной комманды.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    protected $description = 'Migrate the images from a driver to another driver.';

    /**
     * Выполнение комманды.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function handle(): void
    {
        $this->line('Migrating the images of site...');

        $images = ImageStore::all();
        $count = count($images);
        $bar = $this->output->createProgressBar($count);

        for($i = 0; $i < $count; $i++)
        {
            $pathSourceFrom = App::make('image.store.driver')->driver($this->argument('from'))->pathSource($images[$i]['folder'], $images[$i]['id'], $images[$i]['format']);
            App::make('image.store.driver')->driver($this->argument('to'))->create($images[$i]['folder'], $images[$i]['id'], $images[$i]['format'], $pathSourceFrom);
            $bar->advance();
        }

        $bar->finish();
        $this->info('\nThe migration of images has been successfully completed.');
    }
}
