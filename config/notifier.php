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

    /**
     * --------------------------------------------------------------------
     *  Views
     * --------------------------------------------------------------------
     * 
     * Set the views to be used by templatable renderers.
     */
    'views' => [

        'growl' => [

            /**
             * The view to render a single notification.
             */
            'notification' => 'notifier::growl.notification',

            /**
             * The view to renderer all of the rendered noticiations.
             */
            'template' => 'notifier::growl.default',

        ],

        'alertify' => [

            /**
             * The view to render a single notification.
             */
            'notification' => 'notifier::alertify.notification',

            /**
             * The view to renderer all of the rendered noticiations.
             */
            'template' => 'notifier::alertify.default',

        ]

    ],

    /*
     * --------------------------------------------------------------------
     *  Session Prefix
     * --------------------------------------------------------------------
     *
     * The prefix to be prepended to all session keys.
     */
    'sessionPrefix' => 'coreplex.notifier',

    /**
     * --------------------------------------------------------------------
     *  Renderer
     * --------------------------------------------------------------------
     *
     * Set the renderer to be used to render the notifications. Available
     * renderer's are: Coreplex\Notifier\Renderers\Basic or
     * Coreplex\Notifier\Renderers\LaravelBlade
     */
    'renderer' => 'Coreplex\\Notifier\\Renderers\\LaravelBlade',

    'session' => 'Coreplex\\Notifier\\Session\\IlluminateSession',

];