# Intro

The `XdevApi\DefaultSchemaFactory` is like the `XdevApi\SessionFactory` but returns the default schema as set in the config options. This exposes the class methods in the [`mysql_xdevapi\Schema`](https://www.php.net/manual/en/class.mysql-xdevapi-schema.php) class as listed below
```php
mysql_xdevapi\Schema implements mysql_xdevapi\DatabaseObject {
    /* Properties */
    public $name ;
    /* Methods */
    public createCollection ( string $name ) : mysql_xdevapi\Collection
    public dropCollection ( string $collection_name ) : bool
    public existsInDatabase ( void ) : bool
    public getCollection ( string $name ) : mysql_xdevapi\Collection
    public getCollectionAsTable ( string $name ) : mysql_xdevapi\Table
    public getCollections ( void ) : array
    public getName ( void ) : string
    public getSession ( void ) : mysql_xdevapi\Session
    public getTable ( string $name ) : mysql_xdevapi\Table
    public getTables ( void ) : array
}
```

## Usage
First step is to initialise the database schema through the container interface with
```php
$schema = $container->get(XDevApi\DeaultSchemaFactory::class);
```
This can be done in a factory class like [example](#example-factory-class) below.
**NB. The default database schema has to be existing already or an exception will be thrown.**

Once you have instantiated an your default schema you can use all the
methods of `mysql_xdevapi\Schema` as outline above.
## Example Uses
To get a collection in database use
```php
$collection = $schema->getCollection('collection_name');
```
This will return a [`mysql_xdevapi\Collection`](https://www.php.net/manual/en/class.mysql-xdevapi-collection.php) class representing the collection in the database.

Likewise to get a table from the database use
```php
$table = $schema->getTable('table_name');
```
This will return a [`mysql_xdevapi\Table`](https://www.php.net/manual/en/class.mysql-xdevapi-table.php) class representing the table in the database.
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
        $schema         = $container->get(DefaultSchemaFactory::class);
        $postCollection = $schema->getCollection('posts');

        return new PostListHandler($postCollection);
    }
}
```