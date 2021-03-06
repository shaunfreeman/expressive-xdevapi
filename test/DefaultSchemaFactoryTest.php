<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test;

use mysql_xdevapi\Exception;
use mysql_xdevapi\Schema;
use mysql_xdevapi\Session;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use PHPUnit\Framework\TestCase;
use ShaunFreeman\PhpMysqlXdevapi\DefaultSchemaFactory;
use ShaunFreeman\PhpMysqlXdevapi\SessionFactory;
use ShaunFreeman\PhpMysqlXdevapi\XDevApiOptions;

class DefaultSchemaFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testFactoryCanReturnDefaultSchema()
    {
        /** @var ContainerInterface|ObjectProphecy $container */
        $container  = $this->prophesize(ContainerInterface::class);
        /** @var Session|ObjectProphecy $session */
        $session    = $this->prophesize(Session::class);

        /** @var Schema|ObjectProphecy $schema */
        $schema     = $this->prophesize(Schema::class);

        $schema->existsInDatabase()->willReturn(true);
        $session->getSchema('dbname')->willReturn($schema->reveal());
        $container->get(SessionFactory::class)->willReturn($session->reveal());
        $container->get(XDevApiOptions::class)->willReturn(XDevApiOptions::fromArray([
            'schema'    => $_SERVER['MYSQL_DATABASE'],
        ]));

        $factory    = new DefaultSchemaFactory();
        $client     = $factory($container->reveal());

        $this->assertInstanceOf(Schema::class, $client);
    }

    public function testFactoryWillThrowExceptionWhenDefaultSchemaIsNull()
    {
        $this->expectException(Exception::class);

        /** @var ContainerInterface|ObjectProphecy $container */
        $container  = $this->prophesize(ContainerInterface::class);
        /** @var Session|ObjectProphecy $session */
        $session    = $this->prophesize(Session::class);

        /** @var Schema|ObjectProphecy $schema */
        $schema     = $this->prophesize(Schema::class);

        $schema->existsInDatabase()->willReturn(false);
        $session->getSchema('dbname')->willReturn($schema->reveal());
        $container->get(SessionFactory::class)->willReturn($session->reveal());
        $container->get(XDevApiOptions::class)->willReturn(XDevApiOptions::fromArray([
            'schema'    => 'dbname',
        ]));

        $container->get(SessionFactory::class)->willReturn($session->reveal());

        $factory    = new DefaultSchemaFactory();
        $factory($container->reveal());
    }
}
