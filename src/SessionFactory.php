<?php

declare(strict_types=1);

namespace XDevApi;

use mysql_xdevapi\Session;
use Psr\Container\ContainerInterface;

use function mysql_xdevapi\getSession;

final class SessionFactory
{
    private const STRING_DSN = 'mysqlx://%s:%s@%s:%d';

    /**
     * @var XDevApiOptions
     */
    private $xDevApiOptions;

    public function __invoke(ContainerInterface $container): Session
    {
        $this->xDevApiOptions   = $container->get(XDevApiOptions::class);

        return getSession($this->formatDsn());
    }

    private function formatDsn(): string
    {
        return sprintf(
            self::STRING_DSN,
            $this->xDevApiOptions->user,
            $this->xDevApiOptions->password,
            $this->xDevApiOptions->host,
            $this->xDevApiOptions->port
        );
    }
}
