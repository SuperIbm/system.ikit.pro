<?php

return [
    'controllers' => [
        'userController' => [
            'get' => [
                'log' => 'Get the user.'
            ],
            'read' => [
                'log' => 'Read users.'
            ],
            'create' => [
                'log' => 'Create a user.',
                'message' => 'The user has been created.'
            ],
            'update' => [
                'log' => 'Update the user.',
                'message' => 'The user has been updated.'
            ],
            'password' => [
                'log' => 'Update the password of the user.',
                'message' => 'The password has been changed.'
            ],
            'destroy' => [
                'log' => 'Destroy the user.',
                'message' => 'The user has been deleted.'
            ]
        ],
        'userConfigController' => [
            'get' => [
                'log' => 'Get the configs of the user.'
            ],
            'update' => [
                'log' => 'Update the configs of the user.',
                'message' => 'The config of the user has been updated.'
            ],
        ],
    ]
];
