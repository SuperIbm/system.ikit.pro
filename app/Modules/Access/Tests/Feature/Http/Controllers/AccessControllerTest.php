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

use App\Models\Fakers\PhoneFaker;
use Tests\TestCase;
use App\Models\Test\TokenTest;
use Faker\Factory as Faker;

/**
 * Тестирование: Класс контроллер для авторизации и аунтификации.
 *
 * @version 1.0
 * @since 1.0
 * @copyright Weborobot.
 * @author Инчагов Тимофей Александрович.
 */
class AccessControllerTest extends TestCase
{
    use TokenTest;

    /**
     * Получение данных авторизованного пользователя.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testGate(): void
    {
        $this->json('GET', 'api/private/access/access/gate', [], [
            "Authorization" => "Bearer " . $this->getToken()
        ])->assertJsonStructure([
            "success",
            "data" => $this->_getGateStructure()
        ]);
    }

    /**
     * Выход пользователя.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testLogout(): void
    {
        $this->json('POST', 'api/private/access/access/logout', [], [
            "Authorization" => "Bearer " . $this->getToken()
        ])->assertJson([
            "success" => true
        ]);
    }

    /**
     * Регистрация или вход через социальную сеть.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testSocial(): void
    {
        $this->json('POST', 'api/private/access/access/social', [
            'id' => 'test',
            'login' => 'test@test.com',
            'password' => 'admin',
            'type' => 'facebook',
            'first_name' => 'Test',
            'second_name' => 'Test'
        ])->assertJsonStructure([
            "success",
            "data" => [
                "gate" => $this->_getGateStructure(),
                "secret",
                "token" => [
                    "accessToken",
                    "refreshToken"
                ]
            ]
        ]);
    }

    /**
     * Регистрация пользователя.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testSignUp(): void
    {
        $this->json('POST', 'api/private/access/access/sign_up', [
            'login' => 'test2@test.com',
            'password' => 'admin',
            'password_confirmation' => 'admin',
            "first_name" => "Test",
            "second_name" => "Test",
            "telephone" => "+1-666-666-6666"
        ])->assertJsonStructure([
            "success",
            "data" => [
                "gate" => $this->_getGateStructure(),
                "secret",
                "token" => [
                    "accessToken",
                    "refreshToken"
                ]
            ]
        ]);
    }

    /**
     * Авторизация пользователя.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testSignIn(): void
    {
        $this->json('POST', 'api/private/access/access/sign_in', [
            'login' => 'test@test.com',
            'password' => 'admin',
            'remember' => true
        ])->assertJsonStructure([
            "success",
            "data" => [
                "gate" => $this->_getGateStructure(),
                "secret",
                "token" => [
                    "accessToken",
                    "refreshToken"
                ]
            ]
        ]);

        $this->json('POST', 'api/private/access/access/sign_in', [
            'login' => 'test3@test.com',
            'password' => 'admin',
            'remember' => true
        ])->assertJson([
            "success" => false
        ]);
    }

    /**
     * Отправка e-mail сообщения на верификацию.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testVerify(): void
    {
        $this->json('POST', 'api/private/access/access/verify', [], [
            "Authorization" => "Bearer " . $this->getToken()
        ])->assertJson([
            "success" => true
        ]);
    }

    /**
     * Верификация пользователя.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testVerified(): void
    {
        $this->json('POST', 'api/private/access/access/sign_up', [
            'login' => 'test2@test.com',
            'password' => 'admin',
            'password_confirmation' => 'admin',
            "first_name" => "Test",
            "second_name" => "Test",
            "telephone" => "+1-666-666-6666"
        ]);

        $this->json('POST', 'api/private/access/access/verified/2', [
            "code" => "test"
        ], [
            "Authorization" => "Bearer " . $this->getToken()
        ])->assertJsonStructure([
            "success",
            "data" => [
                "gate" => $this->_getGateStructure(),
                "secret",
                "token" => [
                    "accessToken",
                    "refreshToken"
                ]
            ]
        ]);

        $this->json('POST', 'api/private/access/access/verified/3', [
            "code" => "test"
        ], [
            "Authorization" => "Bearer " . $this->getToken()
        ])->assertJson([
            "success" => false
        ]);
    }

    /**
     * Отправка e-mail для восстановления пароля.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testForget(): void
    {
        $this->json('POST', 'api/private/access/access/forget', [
            "login" => 'test@test.com',
        ])->assertJson([
            "success" => true
        ]);

        $this->json('POST', 'api/private/access/access/forget', [
            "login" => 'test2@test.com',
        ])->assertJson([
            "success" => false
        ]);
    }

    /**
     * Проверка возможности сбить пароль.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testResetCheck(): void
    {
        $this->json('POST', 'api/private/access/access/forget', [
            "login" => 'test@test.com',
        ]);

        $this->json('GET', 'api/private/access/access/reset_check/1', [
            "code" => 'test',
        ])->assertJson([
            "success" => true
        ]);

        $this->json('GET', 'api/private/access/access/reset_check/2', [
            "code" => 'test',
        ])->assertJson([
            "success" => false
        ]);
    }

    /**
     * Установка нового пароля.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testReset(): void
    {
        $this->json('POST', 'api/private/access/access/forget', [
            "login" => 'test@test.com',
        ]);

        $this->json('POST', 'api/private/access/access/reset/1', [
            "code" => 'test',
            'password' => '654321',
            'password_confirmation' => '654321'
        ])->assertJson([
            "success" => true
        ]);

        $this->json('GET', 'api/private/access/access/reset_check/2', [
            "code" => 'test',
            'password' => '654321',
            'password_confirmation' => '654321'
        ])->assertJson([
            "success" => false
        ]);
    }

    /**
     * Установка нового пароля.
     *
     * @return void
     * @since 1.0
     * @version 1.0
     */
    public function testUpdate(): void
    {
        $faker = Faker::create();
        $faker->addProvider(new PhoneFaker($faker));

        $this->json('PUT', 'api/private/access/access/update', [
            "first_name" => $faker->firstName,
            "second_name" => $faker->lastName,
            "email" => $faker->email,
            "telephone" => $faker->phone(1),
            "postal_code" => $faker->postcode,
            "country" => $faker->randomNumber(5),
            "city" => $faker->randomNumber(5),
            "region" => $faker->randomNumber(5),
            "street_address" => $faker->address,
            "company_name" => $faker->name()
        ], [
            "Authorization" => "Bearer " . $this->getToken()
        ])->assertJson([
            "success" => true
        ]);
    }

    /**
     * Получение структуры гейта.
     *
     * @return array Вернет структуру гейта.
     * @since 1.0
     * @version 1.0
     */
    private function _getGateStructure(): array
    {
        return [
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
                "wallet" => [
                    "id",
                    "user_id",
                    "amount",
                    "currency"
                ]
            ],
            "schools" => [
                "*" => [
                    "id",
                    "user_id",
                    "plan_id",
                    "image_small_id",
                    "image_middle_id",
                    "image_big_id",
                    "name",
                    "index",
                    "full_name",
                    "description",
                    "status",
                    "plan" => [
                        "id",
                        "name",
                        "price_month",
                        "price_year",
                        "currency",
                        "status"
                    ],
                    "limits" => [
                        "*" => [
                            "name",
                            "description",
                            "type",
                            "unit",
                            "limit",
                            "remain",
                            "from",
                            "to",
                            "trial"
                        ]
                    ],
                    "roles" => [
                        "*" => [
                            "id",
                            "school_id",
                            "user_role_id",
                            "name",
                            "description",
                            "status"
                        ]
                    ],
                    "sections" => [
                        "*" => [
                            "id",
                            "label",
                            "index",
                            "read",
                            "create",
                            "update",
                            "destroy"
                        ]
                    ],
                    "paid" => [
                        "name",
                        "from",
                        "to",
                        "trial"
                    ]
                ]
            ],
            "verified"
        ];
    }
}
