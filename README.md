<p align="center"><a href="https://codingwisely.com" target="_blank"><img src="img.png" alt="Laravel Logo"></a></p>

# Laravel Slug Generator Package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/coding-wisely/laravel-slug-auto-generator.svg?style=flat-square)](https://packagist.org/packages/coding-wisely/laravel-slug-auto-generator)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/coding-wisely/laravel-slug-auto-generator/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/coding-wisely/laravel-slug-auto-generator/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/coding-wisely/laravel-slug-auto-generator/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/coding-wisely/laravel-slug-auto-generator/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/coding-wisely/laravel-slug-auto-generator.svg?style=flat-square)](https://packagist.org/packages/coding-wisely/laravel-slug-auto-generator)

This package hosts a robust and flexible trait designed for effortless slug generation within Laravel applications. Whether you're building a blog, e-commerce platform, or any other web application, managing SEO-friendly URLs becomes seamless with this powerful solution.

## Key Features

- **Automatic Slug Creation**: Automatically generates slugs based on a specified field in your Eloquent models, eliminating the need for manual slug assignment.

- **Unique Slug Enforcement**: Ensures that generated slugs are unique within the database table, preventing conflicts and maintaining data integrity.

- **Customizable Configuration**: Easily configure the field used for slug generation via Laravel's flexible configuration system, adapting to diverse project requirements effortlessly.


## Installation

You can install the package via composer:

```bash
composer require coding-wisely/laravel-slug-auto-generator
```


You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-slug-auto-generator-config"
```

This is the contents of the published config file:

```php
return [
];
```

Optionally, you can publish the views using

```bash
php artisan vendor:publish --tag="laravel-slug-auto-generator-views"
```

## Usage

1. **Integrate the Trait**: Simply integrate the `SlugGenerator` trait into your Eloquent model to unlock its powerful slug generation capabilities.

2. **Configuration**: Customize the slug generation behavior by modifying the `sluggenerator.php` configuration file located in your `config` directory.

3. **Effortless Integration**: With the trait seamlessly integrated into your model, enjoy automatic and unique slug generation without any additional setup.

## Example

```php
use CodingWisely\SlugGenerator\SlugGenerator;
use Illuminate\Database\Eloquent\Model;

class YourModel extends Model
{
    use SlugGenerator;

    // Your model's attributes and methods...
}
```
## Testing

```bash
composer test 
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Vladimir Nikolic](https://github.com/CodingWisely)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
