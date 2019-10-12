<?php /** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest\Repository;

use mysql_xdevapi\Collection;
use mysql_xdevapi\CollectionFind;
use mysql_xdevapi\DocResult;
use mysql_xdevapi\Result;
use mysql_xdevapi\Schema;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use XDevApi\Entity\DocumentEntityInterface;
use XDevApi\Repository\CollectionDocumentInterface;
use XDevApi\Repository\CollectionRepository;
use XDevApi\ValueObject\Uuid;
use XDevApiTest\Assets\TestDocumentEntity;

class CollectionRepositoryTest extends TestCase
{
    /**
     * @var Schema|ObjectProphecy
     */
    private $schema;

    /**
     * @var Collection|ObjectProphecy
     */
    private $collection;

    public function setUp()
    {
        parent::setUp();
        $this->schema = $this->prophesize(Schema::class);
        $this->collection = $this->prophesize(Collection::class);

        $this->schema->getCollection(Argument::type('string'))
            ->shouldBeCalledOnce()
            ->willReturn($this->collection->reveal());
    }

    public function testCollectionRepository()
    {
        $collectionRepository = new CollectionRepository($this->schema->reveal(), 'test');

        $this->assertInstanceOf(CollectionRepository::class, $collectionRepository);
        $this->assertInstanceOf(CollectionDocumentInterface::class, $collectionRepository);
    }

    public function testCount()
    {
        $this->collection->count()->shouldBeCalledOnce()->willReturn(1);
        $collectionRepository = new CollectionRepository($this->schema->reveal(), 'test');
        $count = $collectionRepository->count();

        $this->assertSame(1, $count);
    }

    public function testCanGetCollection()
    {
        $this->collection->getName()->shouldBeCalledOnce()->willReturn('test');
        $collectionRepository = new CollectionRepository($this->schema->reveal(), 'test');
        $defaultCollection = $collectionRepository->getCollection();

        $this->assertInstanceOf(Collection::class, $defaultCollection);
        $this->assertSame('test', $defaultCollection->getName());
    }

    public function testFindAllWillReturnArray()
    {
        /** @var DocResult $docResult */
        $docResult = $this->prophesize(DocResult::class);
        $docResult->fetchAll()->shouldBeCalledOnce()->willReturn([]);
        /** @var CollectionFind $collectionFind */
        $collectionFind = $this->prophesize(CollectionFind::class);
        $collectionFind->offset(0)->shouldBeCalledOnce()->willReturn($collectionFind);
        $collectionFind->limit(25)->shouldBeCalledOnce()->willReturn($collectionFind);
        $collectionFind->execute()->shouldBeCalledOnce()->willReturn($docResult->reveal());
        $this->collection->find('true')->willReturn($collectionFind->reveal());

        $collectionRepository = new CollectionRepository($this->schema->reveal(), 'test');
        $result = $collectionRepository->findAll(0, 25);

        $this->assertSame([], $result);
    }

    public function testCanSaveCollectionDocument()
    {
        $uuid = new Uuid();
        $uuid = $uuid->getHex();

        /** @var DocumentEntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize(DocumentEntityInterface::class);
        $entity->getId()->shouldBeCalledOnce()->willReturn($uuid);
        $entity->jsonSerialize()->shouldBeCalledOnce()->willReturn([]);
        $entity = $entity->reveal();

        $this->collection->addOrReplaceOne($uuid, json_encode([]))
            ->shouldBeCalledOnce()
            ->willReturn(
                $this->prophesize(Result::class)->reveal()
            );

        $collectionRepository = new CollectionRepository($this->schema->reveal(), 'test');
        $result = $collectionRepository->save($entity);

        $this->assertInstanceOf(Result::class, $result);
    }

    public function testCanDeleteCollectionDocument()
    {
        $uuid = new Uuid();
        $uuid = $uuid->getHex();

        /** @var DocumentEntityInterface|ObjectProphecy $entity */
        $entity = $this->prophesize(DocumentEntityInterface::class);
        $entity->getId()->shouldBeCalledOnce()->willReturn($uuid);
        $entity = $entity->reveal();

        $this->collection->removeOne($uuid)
            ->shouldBeCalledOnce()
            ->willReturn(
                $this->prophesize(Result::class)->reveal()
            );

        $collectionRepository = new CollectionRepository($this->schema->reveal(), 'test');
        $result = $collectionRepository->delete($entity);

        $this->assertInstanceOf(Result::class, $result);
    }
}

