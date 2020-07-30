<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test;

use mysql_xdevapi\Session;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use ShaunFreeman\PhpMysqlXdevapi\SessionFactory;
use PHPUnit\Framework\TestCase;
use ShaunFreeman\PhpMysqlXdevapi\XDevApiOptions;

final class SessionFactoryTest extends TestCase
{
    use ProphecyTrait;

    public function testFactoryCanCreateSession()
    {
        /** @var Session|ObjectProphecy $sessionMock */
        $sessionMock = $this->prophesize(Session::class)->reveal();
        uopz_set_return('mysql_xdevapi\getSession', $sessionMock);

        /** @var ContainerInterface|ObjectProphecy $container */
        $container = $this->prophesize(ContainerInterface::class);

        $container->get(XDevApiOptions::class)->willReturn(XDevApiOptions::fromArray([
            'user'      => $_SERVER['MYSQL_USER'],
            'password'  => $_SERVER['MYSQL_PASSWORD'],
            'schema'    => $_SERVER['MYSQL_DATABASE'],
            'host'      => $_SERVER['MYSQL_HOST'],
        ]));

        $container  = $container->reveal();
        $factory    = new SessionFactory();
        $client     = $factory($container);

        $this->assertInstanceOf(Session::class, $client);
    }
}
