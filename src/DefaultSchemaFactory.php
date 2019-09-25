<?php

declare(strict_types=1);


namespace XDevApi;


use BadMethodCallException;
use mysql_xdevapi\Schema;
use mysql_xdevapi\Session;
use Psr\Container\ContainerInterface;

class DefaultSchemaFactory
{
    public function __invoke(ContainerInterface $container): Schema
    {
        /** @var Session $session */
        $session        = $container->get(SessionFactory::class);
        $defaultSchema  = $session->getDefaultSchema();

        if (null === $defaultSchema) {
            throw new BadMethodCallException(sprintf('No default schema is set in %s', XDevApiOptions::class));
        }

        return $defaultSchema;
    }
}
