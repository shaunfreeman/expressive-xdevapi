<?php

declare(strict_types=1);


namespace XDevApi;


use BadMethodCallException;

/**
 * Class XDevApiOptions
 * @package XDevApi
 * @property string $user
 * @property  string $password
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
        return new static(
            $array['user'] ?? '',
            $array['password'] ?? '' ,
            $array['schema'] ?? '',
            $array['host'] ?? '',
            $array['port'] ?? null
        );
    }

    public function __construct(string $user, string $password, string $schema, string $host, ?int $port = null)
    {
        $this->user     = $user;
        $this->password = $password;
        $this->schema   = $schema;
        $this->host     = $host;

        if (is_int($port)) {
            $this->port = $port;
        }
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
