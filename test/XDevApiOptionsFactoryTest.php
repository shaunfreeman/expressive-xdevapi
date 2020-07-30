<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test;

use Prophecy\Prophecy\ObjectProphecy;
use Psr\Container\ContainerInterface;
use ShaunFreeman\PhpMysqlXdevapi\XDevApiOptions;
use ShaunFreeman\PhpMysqlXdevapi\XDevApiOptionsFactory;
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
