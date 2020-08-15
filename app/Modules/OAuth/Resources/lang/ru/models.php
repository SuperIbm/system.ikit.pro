<?php

return [
    'oAuthClient' => [
        'user_id' => 'ID пользователя',
        'secret' => 'Секретный ключ',
        'expires_at' => 'Дата действия'
    ],
    'oAuthDriverDatabase' => [
        "no_client" => "Клиент не сушествует.",
        'no_user' => "Пользователь не существует.",
        'no_valid_secret_code' => "Секретный код не существует.",
        'no_refresh_code' => "Код обновления не существует.",
        'no_valid_token' => "Токен неверен."
    ],
    'oAuthRefreshToken' => [
        'oauth_token_id' => 'ID токена',
        'refresh_token' => 'Токен обновления',
        'expires_at' => 'Дата действия'
    ],
    'oAuthToken' => [
        'oauth_client_id' => 'ID клиента',
        'token' => 'Токена',
        'expires_at' => 'Дата действия'
    ]
];
