<?php

return [
    'name' => 'OAuth',
    'version' => '1.0',
    'date' => '2020-04-08',
    'label' => 'OAuth',

    /*
    |--------------------------------------------------------------------------
    | Драйвер хранения токенов
    |--------------------------------------------------------------------------
    |
    | Определяем систему хранения токенов.
    | database - в базе данных
    |
    */
    'storeDriver' => env('OAUTH_DRIVER', 'database'),
];
