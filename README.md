# Welcome to PHP MySQL XDevApi

[![Build Status](https://travis-ci.org/shaunfreeman/php-mysql-xdevapi.svg?branch=master)](https://travis-ci.org/shaunfreeman/php-mysql-xdevapi)
[![Test Coverage](https://api.codeclimate.com/v1/badges/256e62770cd3ec25b7d3/test_coverage)](https://codeclimate.com/github/shaunfreeman/php-mysql-xdevapi/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/256e62770cd3ec25b7d3/maintainability)](https://codeclimate.com/github/shaunfreeman/php-mysql-xdevapi/maintainability)
[![Packagist](https://img.shields.io/packagist/v/shaunfreeman/php-mysql-xdevapi.svg)](https://packagist.org/packages/shaunfreeman/php-mysql-xdevapi)

This is a [PSR-11](https://www.php-fig.org/psr/psr-11/) library for easy setup of MySQL XDevAPI into [Laminas](https://getlaminas.org/).
To use this library you must have the [PECL mysql_xdevapi](https://pecl.php.net/package/mysql_xdevapi) installed, see [https://www.php.net/manual/en/book.mysql-xdevapi.php](https://www.php.net/manual/en/book.mysql-xdevapi.php) on how to install this extension.

## Installation

Run the following to install this library:

```bash
$ composer require shaunfreeman/php-mysql-xdevapi
```

if you haven't got the 'laminas/laminas-component-installer' installed then in your `config/config.php` file add `\XDevApi\ConfigProvider::class` to the ConfigAggregator like:

```php
...

$aggregator = new ConfigAggregator([
    \ShaunFreeman\PhpMysqlXdevapi\ConfigProvider::class,
... 
```

## Configuration

After installing php-mysql-xdevapi, you will need to first enable the
component, and then optionally configure it.

We recommend adding a new configuration file to your autoload directory,
`config/autoload/xdevapi.local.php`. To begin with, use the following contents:

```php
<?php

declare(strict_types=1);

/**
 * Change the values to match your mysql login
**/
return [
    'xdevapi' => [
        'user'      => 'dbuser',
        'password'  => '654321',
        'host'      => 'mysql',
        'schema'    => 'dbname',
        'port'      => 33060
    ],
];
```

## Support
- Issues [https://github.com/shaunfreeman/php-mysql-xdevapi/issues](https://github.com/shaunfreeman/php-mysql-xdevapi/issues)
- Source [https://github.com/shaunfreeman/php-mysql-xdevapi](https://github.com/shaunfreeman/php=mysql-xdevapi)

## Known Issues
There seems to be a bug when running `mysql_devapi` with `OPcache`, where `CollectionFind::limit()` and `CollectionFind::offset()` will return `bool` when the `OPcache` is enabled.

To workaround this make sure the `OPcache` extension is loaded before the `mysql_xdevapi` extension. 

You may also need to add the line below to your `opcache.ini` file or at the end of your `php.ini` file
``` 
opcache.optimization_level=0
```


