<?php

declare(strict_types=1);

namespace XDevApiTest;

use mysql_xdevapi\Session;
use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use XDevApi\SessionFactory;
use PHPUnit\Framework\TestCase;

final class SessionFactoryTest extends TestCase
{
    public function testFactoryCanCreateSession()
    {
        $sessionMock = $this->prophesize(Session::class)->reveal();
        uopz_set_return('mysql_xdevapi\getSession', $sessionMock);

        /** @var ContainerInterface|ObjectProphecy $container */
        $container = $this->prophesize(ContainerInterface::class);

        $container->get('config')->willReturn([
            'xdevapi' => [
                'user'      => $_SERVER['MYSQL_USER'],
                'password'  => $_SERVER['MYSQL_PASSWORD'],
                'host'      => $_SERVER['MYSQL_HOST'],
                'schema'    => $_SERVER['MYSQL_DATABASE'],
            ],
        ]);

        $container  = $container->reveal();
        $factory    = new SessionFactory;
        $client     = $factory($container);

        $this->assertInstanceOf(Session::class, $client);
    }
}
