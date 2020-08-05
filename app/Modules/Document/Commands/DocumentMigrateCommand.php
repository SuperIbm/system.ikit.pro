<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Commands;

use Illuminate\Console\Command;
use Document;
use App;

/**
 * Класс комманда миграции документов.
 * Позволяет мигрировать документам из одного драйвера хранения в другой.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentMigrateCommand extends Command
{
    /**
     * Название консольной комманды.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    protected $signature = 'weborobot:document-migrate {from : Current driver} {to : Another driver}';

    /**
     * Описание консольной комманды.
     *
     * @var string
     * @version 1.0
     * @since 1.0
     */
    protected $description = 'Migrate the documents from a driver to another driver.';

    /**
     * Выполнение комманды.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function handle(): void
    {
        $this->line('Migrating the documents of site...');

        $documents = Document::all();
        $count = count($documents);
        $bar = $this->output->createProgressBar($count);

        for($i = 0; $i < $count; $i++)
        {
            $pathSourceFrom = App::make('document.driver')->driver($this->argument('from'))->pathSource($documents[$i]['id_document'], $documents[$i]['format']);
            App::make('document.driver')->driver($this->argument('to'))->create($documents[$i]['id_document'], $documents[$i]['format'], $pathSourceFrom);
            $bar->advance();
        }

        $bar->finish();
        $this->info('The migration of documents has been successfully completed.');
    }
}
