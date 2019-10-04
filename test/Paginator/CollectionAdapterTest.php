<?php /** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest\Paginator;

use mysql_xdevapi\Collection;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use XDevApi\Paginator\CollectionAdapter;
use XDevApi\Repository\CollectionDocumentInterface;
use Zend\Paginator\Adapter\AdapterInterface;

class CollectionAdapterTest extends TestCase
{
    /**
     * @var CollectionDocumentInterface
     */
    private $repository;

    public function setUp()
    {
        parent::setUp();

        /** @var CollectionDocumentInterface|ObjectProphecy $repository */
        $repository = $this->prophesize(CollectionDocumentInterface::class);
        /** @var Collection|ObjectProphecy $collection */
        $collection = $this->prophesize(Collection::class);
        $collection->count()->willReturn(1);
        $repository->findAll(Argument::type('integer'), Argument::type('integer'))
            ->willReturn([]);

        $repository->getCollection()->willReturn($collection->reveal());

        $this->repository = $repository;
    }

    public function testCanCreateCollectionAdapter()
    {
        $adapter = new CollectionAdapter($this->repository->reveal());

        $this->assertInstanceOf(AdapterInterface::class, $adapter);
    }

    public function testGetItems()
    {
        $adapter = new CollectionAdapter($this->repository->reveal());

        $result = $adapter->getItems(0, 25);

        $this->assertSame([], $result);
    }

    public function testCount()
    {
        $adapter = new CollectionAdapter($this->repository->reveal());
        $count = $adapter->count();

        $this->assertSame(1, $count);
    }
}

