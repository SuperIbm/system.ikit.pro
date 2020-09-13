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

use Tests\TestCase;

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
        $this->json('POST', 'api/client', [
            'login' => 'test@test.com',
            'password' => 'admin'
        ])->assertJsonStructure([
            "success",
            "data" => [
                "user" => [
                    "id",
                    "image_small_id",
                    "image_middle_id",
                    "login",
                    "remember_token",
                    "first_name",
                    "second_name",
                    "telephone",
                    "two_factor",
                    "flags",
                    "status"
                ],
                "secret"
            ]
        ]);
    }

    /**
     * Генерация токена.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testToken(): void
    {
        $client = $this->json('POST', 'api/client', [
            'login' => 'test@test.com',
            'password' => 'admin'
        ])->getContent();

        $client = json_decode($client, true);

        $this->json('POST', 'api/token', [
            'secret' => $client['data']['secret']
        ])->assertJsonStructure([
            "success",
            "data" => [
                "accessToken",
                "refreshToken"
            ]
        ]);
    }

    /**
     * Генерация токена обновления.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testRefresh(): void
    {
        $client = $this->json('POST', 'api/client', [
            'login' => 'test@test.com',
            'password' => 'admin'
        ])->getContent();

        $client = json_decode($client, true);

        $token = $this->json('POST', 'api/token', [
            'secret' => $client['data']['secret']
        ])->getContent();

        $token = json_decode($token, true);

        $this->json('POST', 'api/refresh', [
            'refreshToken' => $token['data']['refreshToken']
        ])->assertJsonStructure([
            "success",
            "data" => [
                "accessToken",
                "refreshToken"
            ]
        ]);
    }
}
