<?php
/**
 * Модуль Изображения.
 * Этот модуль содержит все классы для работы с изображениями которые хранятся к записям в базе данных.
 *
 * @package App\Modules\Image
 * @since 1.0
 * @version 1.0
 */

namespace App\Modules\Image\Models;

use Config;
use Illuminate\Support\Manager;

/**
 * Класс драйвер хранения записей об изображениях.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class ImageManager extends Manager
{
    /**
     * @see \Illuminate\Support\Manager::getDefaultDriver
     */
    public function getDefaultDriver()
    {
        Config::get('image.record');
    }
}
