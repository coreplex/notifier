<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Notifier
    |--------------------------------------------------------------------------
    |
    | Specify the default notifier config to be used when generating
    | notifications.
    |
    */

    'default' => 'alertify',

    /*
    |--------------------------------------------------------------------------
    | Notifiers
    |--------------------------------------------------------------------------
    |
    | Setup the different notifiers for your application, an example setup
    | for the alertify notifier is added by default.
    |
    */

    'notifiers' => [

        'alertify' => [

            'template' => 'alertify.{{level}}("<strong>{{title}}</strong><br>{{message}}");',
            'css' => [],
            'scripts' => [],
            'levels' => [
                'info' => 'log',
                'success' => 'success',
                'error' => 'error',
            ],

        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Session Key
    |--------------------------------------------------------------------------
    |
    | The key to store the notifications by in the session.
    |
    */

    'sessionKey' => 'coreplex.notifier',
];