<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test\Paginator;

use mysql_xdevapi\Collection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ShaunFreeman\PhpMysqlXdevapi\Paginator\RepositoryAdapter;
use ShaunFreeman\PhpMysqlXdevapi\Repository\CollectionDocumentInterface;
use ShaunFreeman\PhpMysqlXdevapi\Repository\RepositoryInterface;
use Laminas\Paginator\Adapter\AdapterInterface;

class RepositoryAdapterTest extends TestCase
{
    /**
     * @var RepositoryInterface
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();

        /** @var RepositoryInterface|ObjectProphecy $repository */
        $repository = $this->prophesize(RepositoryInterface::class);

        $repository->count()->willReturn(1);
        $repository->findAll(Argument::type('integer'), Argument::type('integer'))
            ->willReturn([]);

        $this->repository = $repository;
    }

    public function testCanCreateCollectionAdapter()
    {
        $adapter = new RepositoryAdapter($this->repository->reveal());

        $this->assertInstanceOf(AdapterInterface::class, $adapter);
    }

    public function testGetItems()
    {
        $adapter = new RepositoryAdapter($this->repository->reveal());

        $result = $adapter->getItems(0, 25);

        $this->assertSame([], $result);
    }

    public function testCount()
    {
        $adapter = new RepositoryAdapter($this->repository->reveal());
        $count = $adapter->count();

        $this->assertSame(1, $count);
    }
}
