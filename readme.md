# Laravel Database Script Manager

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Total Downloads][ico-downloads]][link-downloads]
[![Build Status][ico-travis]][link-travis]
[![StyleCI][ico-styleci]][link-styleci]

Managing database objects in a version controlled application is hard.
Laravel's migrate functionality gets us half way there.
Managing your views, triggers and stored procedures with Laravel's migrations
is error-prone or really verbose (try modifying a table which is used for a view).
 
This package modifies `php artisan migrate` command so that:

1. All script-defined database objects are removed
1. Your migrations are executed
1. All script-defined database objects are added again

## Installation

Via Composer

``` bash
$ composer require karlerss/laravel-db-script-manager
```

## Usage

Create a new script:

`php artisan make:db-script add_active_users_view`

A file similar to a migration file is created in _database/scripts_.

Implement the `up()` and `down()` methods. The down mehtod sql script should check 
if the database object exists (`DROP VIEW IF EXISTS active_users`).

## Testing

``` bash
$ vendor/bin/phpunit
```

## Contributing

Please see [contributing.md](contributing.md) for details and a todolist.

## Security

If you discover any security related issues, please email author email instead of using the issue tracker.

## Credits

- [Karl-Sander Erss][link-author]
- [All Contributors][link-contributors]

## License

MIT. Please see the [license file](license.md) for more information.

[ico-version]: https://img.shields.io/packagist/v/karlerss/laravel-db-script-manager.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/karlerss/laravel-db-script-manager.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/karlerss/laravel-db-script-manager/master.svg?style=flat-square
[ico-styleci]: https://github.styleci.io/repos/184257216/shield

[link-packagist]: https://packagist.org/packages/karlerss/laravel-db-script-manager
[link-downloads]: https://packagist.org/packages/karlerss/laravel-db-script-manager
[link-travis]: https://travis-ci.org/karlerss/laravel-db-script-manager
[link-styleci]: https://styleci.io/repos/184257216
[link-author]: https://github.com/karlerss
[link-contributors]: ../../contributors
