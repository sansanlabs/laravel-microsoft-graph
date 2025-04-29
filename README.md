# Laravel Microsoft Graph

[![Latest Version on Packagist](https://img.shields.io/packagist/v/sansanlabs/laravel-microsoft-graph.svg?style=flat-square)](https://packagist.org/packages/sansanlabs/laravel-microsoft-graph)
[![GitHub Tests Action Status](https://img.shields.io/github/actions/workflow/status/sansanlabs/laravel-microsoft-graph/run-tests.yml?branch=main&label=tests&style=flat-square)](https://github.com/sansanlabs/laravel-microsoft-graph/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/actions/workflow/status/sansanlabs/laravel-microsoft-graph/fix-php-code-style-issues.yml?branch=main&label=code%20style&style=flat-square)](https://github.com/sansanlabs/laravel-microsoft-graph/actions?query=workflow%3A"Fix+PHP+code+style+issues"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/sansanlabs/laravel-microsoft-graph.svg?style=flat-square)](https://packagist.org/packages/sansanlabs/laravel-microsoft-graph)

## Installation

You can install the package via composer:

```bash
composer require sansanlabs/laravel-microsoft-graph
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="microsoft-graph-config"
```

This is the contents of the published config file:

```php
return [
  /*
   * The base URL for Microsoft Graph API
   */
  "base_url" => "https://graph.microsoft.com/v1.0/",

  /*
   * Session key for access token
   */
  "session_key" => "microsoft_access_token",
];
```

## Usage

```php
use SanSanLabs\MicrosoftGraph\Facades\MicrosoftGraph;

public function profile(){
    return MicrosoftGraph::getMyProfile()
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

- [Edi Kurniawan](https://github.com/edikurniawan-dev)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
