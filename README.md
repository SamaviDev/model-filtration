# Filtering the desired model records using query string in Laravel app

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samavidev/model-filtration.svg?style=flat-square)](https://packagist.org/packages/samavidev/model-filtration)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/samavidev/model-filtration/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/samavidev/model-filtration/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/samavidev/model-filtration/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/samavidev/model-filtration/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/samavidev/model-filtration.svg?style=flat-square)](https://packagist.org/packages/samavidev/model-filtration)

This package provides an annotation to retrieve records of a specific model filtered using a query string. Here's a quick example:

```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SamaviDev\ModelFiltration\Attributes\Filter;

#[Filter(['name' => 'username'])]
class User extends Authenticatable
{
    ...
}
```

## Installation

You can install the package via composer:

```bash
composer require samavidev/model-filtration
```

## Usage

- The first argument is valid fields that can be used in the query string. which can be in the form of a string or an array, you can also use an association array to assign a query to a specific model.
- The second argument is the operator that is applied to the table fields (`and`, `or`, `like`, `like:or`). You can even use `with` for relationships. The default value is `and`.

for example:
```php
#[Filter(['name' => 'username', 'email' => 'useremail'], 'or')]
```

It can also be used multiple times.
```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use SamaviDev\ModelFiltration\Attributes\Filter;

#[Filter('id')]
#[Filter(['name' => 'username'])]
class User extends Authenticatable
{
    ...
}
```

##### Filter group definition:
You can also define an `Attribute` class to use as a group of filters for your models. For this, you must implement the `Group` interface.
```php
namespace App\Attributes;

use Attribute;
use SamaviDev\ModelFiltration\Contracts\Group;

#[Attribute]
class UsersFilter implements Group
{
    public function props(): array
    {
        return [
            'or' => ['attribute', ...]
            'and' => ['attribute' => 'alias', ...],
            ...
        ];
    }
}
```
And finally, you can use it in your model like this:
```php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Attributes\UsersFilter;

#[UsersFilter]
class User extends Authenticatable
{
    ...
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
