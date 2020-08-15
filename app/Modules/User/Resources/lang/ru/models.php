<?php

return [
    'blockIp' => [
        'ip' => 'Маска IP',
        'status' => 'Статус'
    ],
    'user' => [
        'image_small_id' => 'Маленькое изображение',
        'image_middle_id' => 'Среднее изображение',
        'login' => 'Логин',
        'password' => 'Пароль',
        'remember_token' => 'Токен',
        'first_name' => 'Имя',
        'second_name' => 'Фамилия',
        'telephone' => 'Телефон',
        'two_factor' => 'Two-factor authentication',
        'status' => 'Статус'
    ],
    'userAddress' => [
        "user_id" => 'ID пользователя',
        'postal_code' => 'Индекс',
        'country' => 'Код страны',
        'region' => 'Код региона',
        'city' => 'Город',
        'street_address' => 'Адрес',
        'latitude' => 'Широта',
        'longitude' => 'Долгота'
    ],
    'userAuth' => [
        'user_id' => 'ID пользователя',
        'os' => 'ОС',
        'device' => 'Устройство',
        'browser' => 'Браузер',
        'agent' => 'Агент',
        'ip' => 'IP',
        'latitude' => 'Долгота',
        'longitude' => 'Широта'
    ],
    'userRecovery' => [
        'user_id' => 'ID пользователя',
        'code' => 'Код'
    ],
    'userReferral' => [
        'referral_id' => "ID реферальной программы",
        'user_invited_id' => "ID пришлашенного пользователя",
        'user_inviting_id' => "ID приглашающего пользователя"
    ],
    'userRole' => [
        'name' => 'Название роли',
        'description' => 'Описание',
        'status' => 'Статус'
    ],
    'userSchool' => [
        'user_id' => "ID пользователя",
        'school_id' => "ID школы",
        'status' => 'Статус'
    ],
    'userSchoolRole' => [
        'user_id' => "ID пользователя",
        'school_role_id' => "ID роль школы"
    ],
    'userVerification' => [
        'user_id' => 'ID пользователя',
        'code' => 'Код',
        'status' => 'Статус'
    ],
    'userWallet' => [
        'user_id' => "ID пользователя",
        'amount' => "Сумма",
        'currency' => "Валюта"
    ],
    'userWalletInput' => [
        'user_wallet_id' => 'ID кошелек пользователя',
        'amount' => 'Сумма'
    ],
    'userWalletOutput' => [
        'user_wallet_id' => 'ID кошелек пользователя',
        'order_charge_id' => 'ID оплаченного счета',
        'amount' => 'Сумма'
    ]
];
