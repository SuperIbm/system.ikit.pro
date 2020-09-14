<?php
/**
 * Тестирование.
 * Пакет содержит классы для выполнения стандартных процедр тестирования.
 *
 * @package App.Models.Test
 * @since 1.0
 * @version 1.0
 */

namespace App\Models\Test;

/**
 * Классы для валидации даты в базе данных MongoDB.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
trait TokenTest
{
    /**
     * Получение токена аунтификации
     *
     * @return string Вернет токен.
     * @since 1.0
     * @version 1.0
     */
    public function getToken(): ?string
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

        return $token['data']['accessToken'];
    }
}
