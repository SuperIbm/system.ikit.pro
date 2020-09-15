<?php

return [
    'update' => [
        'userPipe' => [
            'not_exist_user' => "Пользователь не существует или не найден."
        ]
    ],
    'verified' => [
        'checkPipe' => [
            'not_exist_user' => "Пользователь не существует или не найден.",
            'not_exist_code' => "Верификационный код не существует.",
            'not_correct_code' => "Верификационный код не корректен",
            'user_is_verified' => "Пользователь уже был верифицирован."
        ]
    ]
];
