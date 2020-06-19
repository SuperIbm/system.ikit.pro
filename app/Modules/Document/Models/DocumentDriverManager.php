<?php
/**
 * Модуль Документов.
 * Этот модуль содержит все классы для работы с документами, которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Document
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Document\Models;

use Config;
use Illuminate\Support\Manager;


/**
 * Класс драйвер хранения документов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class DocumentDriverManager extends Manager
{
    /**
     * @see \Illuminate\Support\Manager::getDefaultDriver
     */
    public function getDefaultDriver()
    {
        return Config::get('document.driver');
    }
}
