[![Build Status](https://travis-ci.com/ulrack/configuration.svg?branch=master)](https://travis-ci.com/ulrack/configuration)

# Ulrack Configuration

Ulrack Configuration is package that contains a set of classes which make it possible to create package based configuration.

## Installation

To install the package run the following command:

```
composer require ulrack/configuration
```

## Usage

### [Registry](src/Component/Registry/Registry.php)

The Registry class allows registering data to a key.
This object is returned by the [Compiler](src/Common/CompilerInterface.php).

### [PackageLocator](src/Component/Configuration/PackageLocator.php)

The PackageLocator is a static class which is used to register the location of packages.
This location is used by the compiler to find all configuration files.
To register a package add a `files` node to the `autoload` node in the `composer.json` file.
```json
{
    "autoload": {
        "files": ["locator.php"]
    }
}
```

Then create a `locator.php` file inside root of the package, with the following content:
```php
<?php

use Ulrack\Configuration\Component\Configuration\PackageLocator;

PackageLocator::registerLocation(__DIR__);

```

The package is now added to the locator and can be used by the compiler.

### [Locator](src/Dao/Locator.php)

The Locator class is a DAO which registers behaviour to a sub-directory inside the package. A new locator can be created with the following snippet:
```php
<?php

use Ulrack\Configuration\Dao\Locator;
use Ulrack\Codec\Component\JsonCodec;
use Ulrack\Validator\Component\Logical\AlwaysValidator;


new Locator(
    'database', // The key that the configuration is associated with.
    'configuration/database', // The sub-directory which is crawled by the compiler to fetch the configuration.
    new JsonCodec(512, 0, 0, true), // Or any other class implementing the DecoderInterface from the ulrack/codec package.
    new AlwaysValidator(true) // Or any other class implementing the ValidatorInterface from the ulrack/validator package.
);
```

This locator can then be added to the compiler by calling the `addLocator` method on the compiler.

### [ConfigurationCompiler](src/Component/Compiler/ConfigurationCompiler.php)

The configuration compiler is a class which creates a registry with all registered configuration of all packages.

The compiler requires a `FileSystemDriverInterface` implementation in the constructor to find the files. The standard implementation for this interface can be found in the package `ulrack/vfs`.

Locators can be added by calling the `addLocator` method on the compiler.

After all locators are added, the configuration can be compiled by calling the `compile` method on the ConfigurationCompiler.

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## MIT License

Copyright (c) Jyxon

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
