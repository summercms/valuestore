# Valuestore

[![Latest Version on Packagist](https://img.shields.io/packagist/v/spatie/valuestore.svg?style=flat-square)](https://packagist.org/packages/spatie/valuestore)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/spatie/valuestore/master.svg?style=flat-square)](https://travis-ci.org/spatie/valuestore)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/xxxxxxxxx.svg?style=flat-square)](https://insight.sensiolabs.com/projects/xxxxxxxxx)
[![Quality Score](https://img.shields.io/scrutinizer/g/spatie/valuestore.svg?style=flat-square)](https://scrutinizer-ci.com/g/spatie/valuestore)
[![Total Downloads](https://img.shields.io/packagist/dt/spatie/valuestore.svg?style=flat-square)](https://packagist.org/packages/spatie/valuestore)

This package makes it easy to store some values to a json file and afterwards to retrieve them from the file.

Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## Install

You can install the package via composer:

``` bash
$ composer require spatie/valuestore
```

## Usage

To get started you must first make a new instance of the Valuestore class:
``` php
$valuestore = new Spatie\Valuestore();
```

Next up you must create a file or use an existing json file.
To create a new file or retrieve an existing file:
``` php
$file = $valuestore->make('file-name');
```

To store some values in the file:
``` php
$file->put('value-name', 'value');
```

To get a specific value from the file:
``` php
$file->get('value-name');
```


## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email freek@spatie.be instead of using the issue tracker.

## Credits

- [Freek Van der Herten](https://github.com/freekmurze)
- [Jolita Grazyte](https://github.com/JolitaGrazyte)
- [All Contributors](../../contributors)

## About Spatie
Spatie is a webdesign agency based in Antwerp, Belgium. You'll find an overview of all our open source projects [on our website](https://spatie.be/opensource).

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
