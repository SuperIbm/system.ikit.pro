<?php
/**
 * Модуль Авторизации и аунтификации.
 * Этот модуль содержит все классы для работы с авторизацией и аунтификацией.
 *
 * @package App\Modules\Access
 * @version 1.0
 * @since 1.0
 */

namespace App\Modules\Access\Tests\Feature\Http\Controllers;

use Config;
use Tests\TestCase;
use Storage;

/**
 * Тестирование: Класс контроллер для генерации ключей доступа к API.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessApiControllerTest extends TestCase
{
    /**
     * Генерация клиента.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testClient(): void
    {
        echo env('CACHE_DRIVER');
        echo "\n\n";

        $result = $this->json('POST', 'api/client', [
            'login' => 'test@test.com',
            'password' => 'admin'
        ])->getContent();

        $this->json('POST', 'api/client', [
            'login' => 'test@test.com',
            'password' => 'admin'
        ])->assertJsonStructure([
            "success",
            "data"
        ]);
    }
}
