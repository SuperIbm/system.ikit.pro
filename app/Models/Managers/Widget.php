<?php
/**
 * Менеджеры ядра.
 * Этот пакет содержит менеджеры ядра системы.
 *
 * @package App.Models.Managers
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Managers;

use Illuminate\Support\Manager;

/**
 * Менеджер для виджетов.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class Widget extends Manager
{
    /**
     * Получить драйвера по умолчанию.
     *
     * @return string
     * @version 1.0
     * @since 1.0
     */
    public function getDefaultDriver()
    {
        return null;
    }
}