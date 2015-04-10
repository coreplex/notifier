<?php

return [

    /*
     * --------------------------------------------------------------------
     *  Driver
     * --------------------------------------------------------------------
     *
     * Set the which driver should be used for the notifier, the current
     * drivers are: growl or alertify.
     */
    'driver' => 'growl',

    'views' => [

        'growl' => [

            'notification' => 'notifier::growl.notification',

            'template' => 'notifier::growl.default',

        ]

    ],

    /*
     * --------------------------------------------------------------------
     *  Session Prefix
     * --------------------------------------------------------------------
     *
     * The prefix to be prepended to all session keys.
     */
    'sessionPrefix' => 'nexus.notifier',

];