<?php

declare(strict_types=1);

namespace XDevApi;

use mysql_xdevapi\Exception;
use mysql_xdevapi\Schema;
use mysql_xdevapi\Session;
use Psr\Container\ContainerInterface;

final class DefaultSchemaFactory
{
    public function __invoke(ContainerInterface $container): Schema
    {
        /** @var Session $session */
        $session        = $container->get(SessionFactory::class);
        /** @var XDevApiOptions $xDevOptions */
        $xDevOptions    = $container->get(XDevApiOptions::class);
        $defaultSchema  = $session->getSchema($xDevOptions->schema);

        if (!$defaultSchema->existsInDatabase()) {
            throw new Exception(sprintf('Schema: "%s" does not exist in database', $xDevOptions->schema));
        }

        return $defaultSchema;
    }
}
