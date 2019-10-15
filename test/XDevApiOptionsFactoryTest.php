<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest;

use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use XDevApi\XDevApiOptions;
use XDevApi\XDevApiOptionsFactory;
use PHPUnit\Framework\TestCase;

class XDevApiOptionsFactoryTest extends TestCase
{
    public function testFactoryCanReturnOptionsClass()
    {
        /** @var ContainerInterface|ObjectProphecy $container */
        $container = $this->prophesize(ContainerInterface::class);
        $container->get('config')->willReturn([
            'xdevapi' => [
                'user'      => 'dbuser',
                'password'  => '654321',
                'host'      => 'mysql',
                'schema'    => 'dbname',
                'port'      => 33060
            ],
        ]);

        $factory = new XDevApiOptionsFactory();
        $options = $factory($container->reveal());

        $this->assertInstanceOf(XDevApiOptions::class, $options);
    }
}
