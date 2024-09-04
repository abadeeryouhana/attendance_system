<?php

return [
    'defaults' => [
        'guard' => 'api',
        'passwords' => 'users',
    ],

    'guards' => [
        'api' => [
            'driver' => 'jwt',
            'provider' => 'users',
        ],
        'app_user' => [
            'driver' => 'jwt',
            'provider' => 'app_user',
        ]
    ],

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class,
        ],
        'app_user' => [
            'driver' => 'eloquent',
            'model' => \App\Models\User::class,
        ]

    ],
];
