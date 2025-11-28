<?php

return [

    'defaults' => [
        'guard' => 'admin',
        'passwords' => 'administradores',
    ],

    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'administradores',
        ],
    ],

    'providers' => [
        'administradores' => [
            'driver' => 'eloquent',
            'model' => App\Models\Administrador::class,
        ],
    ],

    'passwords' => [
        'administradores' => [
            'provider' => 'administradores',
            'table' => 'password_resets',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => 10800,
];
