<?php

declare(strict_types=1);

namespace XDevApiTest;

use BadMethodCallException;
use mysql_xdevapi\Schema;
use mysql_xdevapi\Session;
use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use XDevApi\DefaultSchemaFactory;
use XDevApi\SessionFactory;

class DefaultSchemaFactoryTest extends TestCase
{

    public function testFactoryCanReturnDefaultSchema()
    {
        /** @var ContainerInterface $container */
        $container  = $this->prophesize(ContainerInterface::class);
        /** @var Session $session */
        $session    = $this->prophesize(Session::class);

        $session->getDefaultSchema()->willReturn($this->prophesize(Schema::class)->reveal());
        $container->get(SessionFactory::class)->willReturn($session->reveal());

        $factory    = new DefaultSchemaFactory;
        $client     = $factory($container->reveal());

        $this->assertInstanceOf(Schema::class, $client);
    }

    public function testFactoryWillThrowExceptionWhenDefaultSchemaIsNull()
    {
        $this->expectException(BadMethodCallException::class);

        /** @var ContainerInterface $container */
        $container  = $this->prophesize(ContainerInterface::class);
        /** @var Session $session */
        $session    = $this->prophesize(Session::class);

        $session->getDefaultSchema()->willReturn(null);
        $container->get(SessionFactory::class)->willReturn($session->reveal());

        $factory    = new DefaultSchemaFactory;
        $factory($container->reveal());
    }
}

