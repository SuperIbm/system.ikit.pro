<?php

return [
    'requests' => [
        'alertDestroy' => [
            'ids' => 'ID',
        ],
        'alertRead' => [
            'start' => 'Начало',
            'limit' => 'Лимит',
            'unread' => 'Не прочитано'
        ],
        'alertToRead' => [
            'status' => 'Статус'
        ]
    ],
    'controllers' => [
        'alertController' => [
            'toRead' => [
                'log' => 'Чтение предупреждений.'
            ],
            'destroy' => [
                'log' => 'Удаление предупреждения.'
            ],
        ]
    ]
];
