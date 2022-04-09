# HRMS - Filament php

Human resource managment system implemented with filament php.

## System Requirement

- PHP 8.0+
- Laravel v8.0+
- Livewire v2.0+
- MariaDB v10.7.3


## Setup local environment

You can clone the project using git clone command:

```bash
git clone https://github.com/omakei/hrms-filament.git
```

after clone the project you can change directory to project directory and copy `.env` file
using copy command:

```bash
cp .env.example .env
```

Then you can install the dependence using this command:

```bash
composer install
```

Generate app key and places inside the `.env` file

```bash
php artisan key:generate
```

Run database migration

```bash
php artisan migrate:fresh 
```

Create Filament user 

```bash
php artisan make:filament-user
```

Start local server

```bash
php artisan serve
```

Now you can access the app via [http://localhost:8000](http://localhost:8000).

## Running Test
```bash
php artisan test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [omakei](https://github.com/omakei)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
