<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test\Entity;

use Prophecy\Prophecy\ObjectProphecy;
use ShaunFreeman\PhpMysqlXdevapi\Entity\DocumentEntityCollection;
use PHPUnit\Framework\TestCase;
use ShaunFreeman\PhpMysqlXdevapi\Paginator\RepositoryAdapter;
use ShaunFreeman\PhpMysqlXdevapi\Repository\RepositoryInterface;
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
