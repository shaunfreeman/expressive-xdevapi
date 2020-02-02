<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test\Repository;

use mysql_xdevapi\Collection;
use mysql_xdevapi\CollectionFind;
use mysql_xdevapi\DocResult;
use mysql_xdevapi\Result;
use mysql_xdevapi\Schema;
use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use ShaunFreeman\PhpMysqlXdevapi\Entity\DocumentEntityInterface;
use ShaunFreeman\PhpMysqlXdevapi\Repository\CollectionDocumentInterface;
use ShaunFreeman\PhpMysqlXdevapi\Repository\CollectionRepository;
use ShaunFreeman\PhpMysqlXdevapi\ValueObject\Uuid;
use ShaunFreeman\PhpMysqlXdevapi\Test\Assets\RepositoryOverride;
use ShaunFreeman\PhpMysqlXdevapi\Assets\TestDocumentEntity;

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

    private $dbRetrunArray = [
        ['_id' => '235d3f0038e9483da685a6c28a46a078', 'test_field1' => 'test1'],
        ['_id' => '1c75382efc8545bb8086da6ad91a3230', 'test_field2' => 'test2'],
    ];

    public function setUp()
    {
        parent::setUp();
        $this->schema = $this->prophesize(Schema::class);
        $this->collection = $this->prophesize(Collection::class);

        $this->schema->getCollection('test')
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

    public function testFindAllWillReturnHydratedArray()
    {
        /** @var DocResult $docResult */
        $docResult = $this->prophesize(DocResult::class);
        $docResult->fetchAll()->shouldBeCalledOnce()->willReturn($this->dbRetrunArray);
        /** @var CollectionFind $collectionFind */
        $collectionFind = $this->prophesize(CollectionFind::class);
        $collectionFind->offset(0)->shouldBeCalledOnce()->willReturn($collectionFind);
        $collectionFind->limit(25)->shouldBeCalledOnce()->willReturn($collectionFind);
        $collectionFind->execute()->shouldBeCalledOnce()->willReturn($docResult->reveal());
        $this->collection->find('true')->willReturn($collectionFind->reveal());

        $collectionRepository = new CollectionRepository($this->schema->reveal(), 'test');
        $result = $collectionRepository->findAll(0, 25);

        foreach ($result as $row) {
            $this->assertInstanceOf(DocumentEntityInterface::class, $row);
        }
    }

    public function testFindAllWillCallFindAllSort()
    {
        /** @var DocResult $docResult */
        $docResult = $this->prophesize(DocResult::class);
        $docResult->fetchAll()->shouldBeCalledOnce()->willReturn($this->dbRetrunArray);
        /** @var CollectionFind $collectionFind */
        $collectionFind = $this->prophesize(CollectionFind::class);
        $collectionFind->offset(0)->shouldBeCalledOnce()->willReturn($collectionFind);
        $collectionFind->limit(25)->shouldBeCalledOnce()->willReturn($collectionFind);
        $collectionFind->sort('$.date_created ASC')->shouldBeCalledOnce()->willReturn($collectionFind);
        $collectionFind->execute()->shouldBeCalledOnce()->willReturn($docResult->reveal());
        $this->collection->find('true')->willReturn($collectionFind->reveal());

        $collectionRepository = new RepositoryOverride($this->schema->reveal(), 'test');
        $result = $collectionRepository->findAll(0, 25);

        foreach ($result as $row) {
            $this->assertInstanceOf(DocumentEntityInterface::class, $row);
        }
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
