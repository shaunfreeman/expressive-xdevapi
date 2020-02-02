<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi;

use BadMethodCallException;

/**
 * Class XDevApiOptions
 * @package XDevApi
 * @property string $user
 * @property string $password
 * @property string $schema
 * @property string $host
 * @property int $port
 */
final class XDevApiOptions
{
    private $user;

    private $password;

    private $schema;

    private $host = 'localhost';

    private $port = 33060;

    public static function fromArray(array $array): XDevApiOptions
    {
        $static             = new static();
        $static->user       = $array['user'] ?? '';
        $static->password   = $array['password'] ?? '';
        $static->schema     = $array['schema'] ?? '';
        $static->host       = $array['host'] ?? '';

        if (isset($array['port']) && is_int($array['port'])) {
            $static->port = $array['port'];
        }

        return $static;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }

    public function __get($name)
    {
        if (!property_exists(self::class, $name)) {
            throw new BadMethodCallException(sprintf("Method '%s' in class %s does not exist.", $name, self::class));
        }
        return $this->{$name};
    }
}
