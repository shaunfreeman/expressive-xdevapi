# Intro

At the basic level Expressive X DevApi creates a X DevApi session. This exposes all the class methods in the [Session Class](https://www.php.net/manual/en/class.mysql-xdevapi-session.php), these are listed below.

Using the API this way gives you the most flexibility as you can access many schemas. Most times you will be using just one schema so the [`XDevApi\DefaultSchemaFactory`](default-schema-factory.md) will be better.

```php
mysql_xdevapi\Session {
    /* Methods */
    public close ( void ) : bool
    public commit ( void ) : Object
    public createSchema ( string $schema_name ) : mysql_xdevapi\Schema
    public dropSchema ( string $schema_name ) : bool
    public generateUUID ( void ) : string
    public getDefaultSchema ( void ) : string
    public getSchema ( string $schema_name ) : mysql_xdevapi\Schema
    public getSchemas ( void ) : array
    public getServerVersion ( void ) : integer
    public listClients ( void ) : array
    public quoteName ( string $name ) : string
    public releaseSavepoint ( string $name ) : void
    public rollback ( void ) : void
    public rollbackTo ( string $name ) : void
    public setSavepoint ([ string $name ] ) : string
    public sql ( string $query ) : mysql_xdevapi\SqlStatement
    public startTransaction ( void ) : void
}
```

## Usage
To setup a X DevApi session the best way is to call `XDevApi\SessionFactory` through a factory class like, see [Example factory Class](#example-factory-class).
```php
$session = $container->get(XDevApi\SessionFactory::class);
```
Calling the X DevApi Session this way no database schema is set, so you will have to call one by something like
```php
$schema = $session->getSchema('dbname');
```
See [Session Class](https://www.php.net/manual/en/class.mysql-xdevapi-session.php) for more details on these methods.

## Example Factory Class
```php
<?php

declare(strict_types=1);

namespace Blog\Handler;

use Psr\Container\ContainerInterface;
use XDevApi\DefaultSchemaFactory;

class PostListHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostListHandler
    {
        $session = $container->get(DefaultSchemaFactory::class);
        return new PostListHandler($session);
    }
}
```