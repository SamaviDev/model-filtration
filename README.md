# Filtering the desired model records using query string in Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samavidev/model-filtration.svg?style=flat-square)](https://packagist.org/packages/samavidev/model-filtration)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/samavidev/model-filtration/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/samavidev/model-filtration/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/samavidev/model-filtration/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/samavidev/model-filtration/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/samavidev/model-filtration.svg?style=flat-square)](https://packagist.org/packages/samavidev/model-filtration)

This package provides an annotation to retrieve records of a specific model filtered using a query string. Here's a quick example:

```php
use App\Models\User;
use SamaviDev\ModelFiltration\Attributes\Filter;

class MyController
{
    #[Filter(User::class, 'and', ['name', 'email'])]
    public function myMethod($users)
    {
    }
}
```

## Installation

You can install the package via composer:

```bash
composer require samavidev/model-filtration
```

## Usage

- The first argument of the model you want to filter using the query string.
- The second argument is the operand that is applied to the table fields (`and`, `or`, `like`, `like:or`). You can even use `with` for relationships.
- The third argument is the valid fields that can be used in the query string.

```php
#[Filter(User::class, 'and', ['name', 'email'])]
```

```php
#[Filter(User::class, 'or', ['name', 'email'])]
```

```php
#[Filter(User::class, 'like', ['name', 'email'])]
```

```php
#[Filter(User::class, 'like:or', ['name', 'email'])]
```

```php
#[Filter(User::class, 'with', 'relationship')]
```

It can also be used multiple times.
```php
use App\Models\User;
use SamaviDev\ModelFiltration\Attributes\Filter;

class MyController
{
    #[Filter(User::class, 'or', ['field1', 'field2'])]
    #[Filter(User::class, 'like', ['field3'])]
    #[Filter(User::class, 'with', 'relationship')]
    public function myMethod($users)
    {
    }
}
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Mahdi Samavi](https://github.com/SamaviDev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
