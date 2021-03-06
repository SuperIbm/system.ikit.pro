<?php
return [
    'name' => 'Image',

    /*
    |--------------------------------------------------------------------------
    | Мягкое удаление
    |--------------------------------------------------------------------------
    |
    | Позволяет не удалять физически изображения с жесткого диска
    |
    */
    'softDeletes' => env('IMAGE_SOFT', true),

    /*
    |--------------------------------------------------------------------------
    | Место хранения записей об изображениях
    |--------------------------------------------------------------------------
    |
    | Здесь можно определить место хранения для записей об изображениях.
    | Доступны значения: "database" - база данных, "mongodb" - MongoDb
    |
    */
    'record' => env('IMAGE', 'mongodb'),

    /*
    |--------------------------------------------------------------------------
    | Драйвер хранения изображений
    |--------------------------------------------------------------------------
    |
    | Определяем систему хранения изображений.
    | base - в базе данных, local - локально в папке, ftp - через FTP протокол в папке
    | http - через HTTP протокол в папке
    |
    */
    'storeDriver' => env('IMAGE_DRIVER', 'local'),


    /*
    |--------------------------------------------------------------------------
    | Настройка хранилищь для изображений
    |--------------------------------------------------------------------------
    |
    | В этом месте можно определить доступы к хранилищу изображений
    |
    */
    'store' => [
        'base' => [
            'table' => 'images',
            'property' => 'byte'
        ],
        'local' => [
            'path' => 'storage/images/',
            'pathSource' => storage_path('app/public/images/'),
        ],
        'ftp' => [
            'server' => 'weborobot.ru',
            'login' => 'weborobot',
            'password' => 'O4z1S0f6',
            'path' => 'www/images/'
        ],
        'http' => [
            'read' => 'http://loc.weborobot.ru/storage/images/',
            'create' => 'http://loc.weborobot.ru/img/create/',
            'update' => 'http://loc.weborobot.ru/img/update/',
            'destroy' => 'http://loc.weborobot.ru/img/destroy/',
        ]
    ]
];
