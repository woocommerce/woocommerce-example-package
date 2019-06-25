# WooCommerce Example Package

This is an example feature plugin package for WooCommerce. It is setup so that it can be installed standalone as a WordPress plugin, or included into another project/WooCommerce core as a Composer Package.

## Installing Composer

You need Composer to use the packages. If you don't have it installed, go and check how to [install Composer](https://github.com/woocommerce/woocommerce/wiki/How-to-set-up-WooCommerce-development-environment) and then continue here.

## Installing packages

Once you have defined your package requirements, run

```
composer install
```

and that will install the required Composer packages.

The example package has some package requirements defined:
- `"automattic/jetpack-autoloader"` - Handles autoloading and prevents version conflicts between packages.
- `"composer/installers"` - Allows the plugin to be installed via composer and moved to the correct install directory.
- `"phpunit/phpunit"` - Runs unit tests.
- `"woocommerce/woocommerce-sniffs"` - Checks for coding standards violations.

## Main directories and files

- `woocommerce-example-package.php` - The main plugin file. ONLY used when using this package as a plugin!
- `src/` - PSR-4 named classes under your namespace are placed here. Classes will be autoloaded.
- `src/Package.php` - The package class requires 3 static methods; 
  - `init` - Init your package. If it needs to hook into WordPress, do so here.
  - `get_version` - Return the version of your package here. This will be used by WooCommerce in the system status report.
  - `get_path` - Return the package main directory. This will be used by WooCommerce in the system status report.
- `tests/` - Unit tests ran using `phpunit`.

## Adding and running unit tests

Tests should be added in the `tests/Tests` directory.

You can run the tests by running the command

```
./vendor/bin/phpunit
```

from the plugin directory.
