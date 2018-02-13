# image-fit for Laravel 5.*
Laravel image fit


## Installation

The Image-Fit Service Provider can be installed via [Composer](http://getcomposer.org) by requiring the
`nassajis/image-fit` package and setting the `minimum-stability` to `dev` (required for Laravel 5) in your
project's `composer.json`.

```json
{
    "require": {
        "laravel/framework": "5.*",
        "nassajis/image-fit": "^1.2"
    }
}
```

or

Require this package with composer:

```
composer require nassajis/image-fit
```

Update your packages with ```composer update``` or install with ```composer install```.


Find the `providers` key in `config/app.php` and register the ImageFit Service Provider.

for Laravel 5.+
```php
    'providers' => [
        // ...
        Nassajis\ImageFit\ImageFitServiceProvider::class,
    ]
```
for Laravel 5.0
```php
    'providers' => [
        // ...
        'Nassajis\ImageFit\ImageFitServiceProvider',
    ]
```

Copy the package config to your local config with the publish command:

```shell
php artisan vendor:publish --provider="Nassajis\ImageFit\ImageFitServiceProvider"
```

```shell
width & height * 10
```
