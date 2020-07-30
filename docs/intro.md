# Introduction

This example will show how you can configure PHP MySQL XDevApi in [Laminas](https://getlaminas.org).

## Configuration
Once you have you have installed PHP MySQL XDevApi by following the procedure from the [Installation](index.md) guide, you will have to add a new ini file in your `config/autoload` folder. So for simplicity I will call it `xdevapi.local.php` **NB. make sure you do not include this file in your VCS repo, as it will contain your database user and password details**

So in `config/autoload/xdevapi.local.php` put an array with the key `xdevapi` and your database connection details like below:

```php
<?php

declare(strict_types=1);

return [
    'xdevapi' => [
        'user'      => '<database username>',
        'password'  => '<database password>',
        'host'      => '<database host>',
        'schema'    => '<database schema name>',
        'port'      => 33060
    ],
];
```
Change these values to reflect your MySQL login details.

Next, if it hasn't already be done, you will need to add `\ShaunFreeman\PhpMysqlXdevapi\ConfigProvider::class` to your `config/config.php` like

```php
...
$aggregator = new ConfigAggregator([
    \ShaunFreeman\PhpMysqlXdevapi\ConfigProvider::class,
...
```
Now that is done you are ready to use Expressive X DevApi.
