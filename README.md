# Notifier [![Build Status](https://travis-ci.org/coreplex/notifier.svg?branch=master)](https://travis-ci.org/coreplex/notifier)

A PHP package to simply flash notifications and then render them with a JavaScript notifier. This package also comes 
with Laravel support out of the box.

- [Installation](#installation)
- [Laravel 5 Integration](#laravel-5-integration)
- [Usage](#usage)
- [Usage With Laravel](#usage-with-laravel)
- [Adding Notifications](#adding-notifications)
- [Rendering Notifications](#rendering-notifications)
- [Setting up a Notifier](#setting-up-a-notifier)
    - [Setting a Template](#setting-a-template)
    - [Setting Notification levels](#setting-notification-levels)
    - [Setting Scripts and Styles](#setting-scripts-and-styles)

## Installation
This package requires PHP 5.4+, and includes a Laravel 5 Service Provider and Facade.

We recommend installing the package through composer. You can either call `composer require coreplex/notifier` in your 
command line, or add the following to your `composer.json` and then run either `composer install` or `composer update` 
to download the package.

```php
"coreplex/notifier": "~0.2"
```

## Laravel 5 Integration

To use the package with Laravel 5 firstly add the carpenter service provider to the list of service providers 
in `app/config/app.php`.

```php
'providers' => array(

  Coreplex\Notifier\NotifierServiceProvider::class,

);
```

If you wish to use the facade then add the following to your aliases array in `app/config/app.php`.

```php
'aliases' => array(

  Notifier'  => Coreplex\Notifier\Facades\Notifier::class,
  
);
```

Finally once you've added the service provider run `php artisan vendor:publish` to publish the config file.

## Usage

The notifier is made up of a couple of components; a template parser and a session class. This package comes with a 
template parser and a native PHP session class.

However if you wish to make your own session or template parser you simply need to implement the Session or 
TemplateParser interfaces.

To make the default template parser you simply need to make a new instance of the Parser class. This class has no 
dependencies so it's a simple case of creating the object.

```php
$parser = new Coreplex\Notifier\Parser();
```

The native session class requires the package config as a dependency.

```php
$config = require "path/to/config.php";

$session = new Coreplex\Notifier\Session\Native($config);
```

Once you have the template parser and session you are ready to create the notifier. The notifier also requires the 
package config as a third parameter.

```php
$notifier = new Coreplex\Notifier\Notifier($parser, $session, $config);
```

## Usage With Laravel

Once you've set up the package to access the notifier you can either user the facade or you can inject the class by its
interface.

```php
Notifier::render();

public function __construct(\Coreplex\Notifier\Contracts\Notifier $notifier)
{
    $this->notifier = $notifier;
}
```

## Adding Notifications

To add a notification you can either call the `notify` method and pass a notification level, or you can call the 
notification level as a method. You specify the notification levels in the notifier config, you can see more about this 
in the [setting up a notifier](#setting-up-a-notifier) section below.

```php
$notifier->notify('success');

$notifier->success();
```

To pass data to the notification pass an array of key value pairs.

```php
$notifier->notify('success', [
    'title' => 'Success',
]);

$notifier->success([
   'title' => 'Success',
]);
```

You can also add multiple notifications per request and they will all be rendered.
 
```php
$notifier->success(['title' => 'Foo']);
$notifier->error(['title' => 'Bar']);
```

## Rendering Notifications

To render notifications simply call the `render` method.

```php
<?php echo $notifier->render(); ?>
```

## Setting up a Notifier

To add a notifier you simply need to a it into the `notifiers` array in the `notifier.php` config file. By default the 
package comes with config for the excellent [alertify](http://fabien-d.github.io/alertify.js/) notifier.

```php
'notifiers' => [

    'alertify' => [
    
        'template' => 'alertify.{{ level }}("<strong>{{ title }}</strong><br>{{ message }}");',
        'css' => [],
        'scripts' => [],
        'levels' => [
            'info' => 'log',
            'success' => 'success',
            'error' => 'error',
        ],
    
    ],

],
```

A notifier is registered by adding an array made up of a template and the notification levels, and optionally any css 
files and js scripts.

### Setting a Template

The template is used to render the notifications. When you call the `render` method it will loop through all of the 
notifications and render them to this template.

The template is always passed the notification level and then is also passed the array of dynamic data. To call access 
the data you wrap the key in double curly braces like so:

```php
'template' => 'notifier.{{ level }}("Hello World!");'
```

If a success notification was called using this template it would be rendered to the following string.

    <script>notifier.success("Hello World!");</script>
    
It's very like that you wouldn't want to hard code the body of the notification so to access that dynamic data in the 
template you could use the following template.

```php
'template' => 'notifier.{{ level }}("{{ body }}");'
```

Occasionally you may also only want to render data if it's been passed through. For example in the following template 
it will only render an icon if one has been passed through.

```php
'template' => 'notifier.{{ level }}("[if:icon] {{ icon }} [endif] {{ body }}");
```

### Setting Notification levels

Each notifier may have different names for their levels. To add some consistency the package by default requires an info,
success and error level notifications. In the levels array you can specify the name your notifier uses for those levels.

For example with the [alertify](http://fabien-d.github.io/alertify.js/) package it comes with log, success and error  
notification levels. So the levels array would look like the following:

```php
'levels' => [
    'info' => 'log',
    'success' => 'success',
    'error' => 'error',
],
```

However you may wish for to have access to more levels than that so to register custom levels just add them to the 
array.

```php
'levels' => [
    'info' => 'log',
    'success' => 'success',
    'error' => 'error',
    'custom' => 'fooBar',
],
```

This level can then be called either using the `notify` method or by calling the name on the notifier instance.

```php
$notifier->notify('custom');

$notifier->custom();
```

### Setting Scripts and Styles

If you are using multiple notifiers then you may not wish to load all of the styles or scripts on every request, but 
 only when that notifer is being used. To do this you can set the paths to your styles in the `css` array and the paths
 to your js files in the `scripts` array.
 
```php
'css' => [
    'path/to/styles.css'
],
'scripts' => [
    'path/to/scripts.js'
],
```

Then to render the styles us the `styles` method and to render the scripts use the `scripts` method.

```php
<head>
    <?php echo $notifier->styles(); ?>
</head>
<body>
    <?php echo $notifier->scripts(); ?>
</body>
```