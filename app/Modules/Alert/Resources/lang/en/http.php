<?php

return [
    'requests' => [
        'alertDestroy' => [
            'ids' => 'ID',
        ],
        'alertRead' => [
            'start' => 'Start',
            'limit' => 'Limit',
            'unread' => 'Unread'
        ],
        'alertToRead' => [
            'status' => 'Status'
        ]
    ],
    'controllers' => [
        'alertController' => [
            'toRead' => [
                'log' => 'Read alerts.'
            ],
            'destroy' => [
                'log' => 'Destroy the alert.'
            ],
        ]
    ]
];
