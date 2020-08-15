<?php

return [
    'update' => [
        'userPipe' => [
            'not_exist_user' => "The user doesn't exist or not find it."
        ]
    ],
    'verified' => [
        'checkPipe' => [
            'not_exist_user' => "The user doesn't exist or not find it.",
            'not_exist_code' => "The verification code doesn't exist.",
            'not_correct_code' => "The verification code is not correct.",
            'user_is_verified' => "The user has been already verified."
        ]
    ]
];
