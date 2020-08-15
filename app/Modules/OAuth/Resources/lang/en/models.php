<?php

return [
    'oAuthClient' => [
        'user_id' => 'ID user',
        'secret' => 'Secret',
        'expires_at' => 'Expires date'
    ],
    'oAuthDriverDatabase' => [
        "no_client" => "The client does not find.",
        'no_user' => "The user does not exist.",
        'no_valid_secret_code' => "The secret code is not valid.",
        'no_refresh_code' => "The refresh token does not exist.",
        'no_valid_token' => "The token is not valid."
    ],
    'oAuthRefreshToken' => [
        'oauth_token_id' => 'ID token',
        'refresh_token' => 'Refresh token',
        'expires_at' => 'Expires date'
    ],
    'oAuthToken' => [
        'oauth_client_id' => 'ID client',
        'token' => 'Token',
        'expires_at' => 'Expires date'
    ]
];
