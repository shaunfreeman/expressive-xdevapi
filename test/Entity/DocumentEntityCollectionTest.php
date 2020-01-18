<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest\Entity;

use Prophecy\Prophecy\ObjectProphecy;
use XDevApi\Entity\DocumentEntityCollection;
use PHPUnit\Framework\TestCase;
use XDevApi\Paginator\RepositoryAdapter;
use XDevApi\Repository\RepositoryInterface;
use Laminas\Paginator\Paginator;

class DocumentEntityCollectionTest extends TestCase
{
    public function testCanCreateCollection()
    {
        /** @var RepositoryInterface|ObjectProphecy $repository */
        $repository = $this->prophesize(RepositoryInterface::class);
        $collection = new DocumentEntityCollection(new RepositoryAdapter($repository->reveal()));

        $this->assertInstanceOf(DocumentEntityCollection::class, $collection);
        $this->assertInstanceOf(Paginator::class, $collection);
    }
}
