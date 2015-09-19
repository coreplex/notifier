<?php

return [
    'default' => 'alertify',

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

        'growl' => [

            'template' => '$.growl.{{level}}({ title: "{{title}}", message: "{{message}}" });',
            'css' => [],
            'js' => [],
            'levels' => [
                'info' => 'warning',
                'success' => 'notice',
                'error' => 'error',
            ],

        ],

        'igrowl' => [

            'template' => '$.iGrowl({
                type: "{{ type }}",
                title: "{{ title }}",
                message: "{{ message }}",
                [if]icon: "{{ icon }}",[endif]
            });',
            'css' => [],
            'js' => [],
            'levels' => [
                'info' => 'warning',
                'success' => 'notice',
                'error' => 'error',
            ],

        ],
    ],

    'sessionKey' => 'coreplex.notifier',
];