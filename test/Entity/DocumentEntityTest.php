<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test\Entity;

use PHPUnit\Framework\TestCase;
use ShaunFreeman\PhpMysqlXdevapi\Entity\DocumentEntity;
use ShaunFreeman\PhpMysqlXdevapi\Entity\DocumentEntityInterface;
use ShaunFreeman\PhpMysqlXdevapi\ValueObject\Uuid;

class DocumentEntityTest extends TestCase
{
    public function testCanCreateNewDocumentEntity()
    {
        $entity = new DocumentEntity();

        $this->assertInstanceOf(DocumentEntityInterface::class, $entity);
        $this->assertInstanceOf(DocumentEntity::class, $entity);
    }

    public function testCanCreateNewDocumentEntityWithArguments()
    {
        $entity = new DocumentEntity('1e1d9e34b99c48f19974402247442ca2', [
            'test_field1' => 'test1',
            'test_field2' => 'test2',
            'test_field3' => 'test3',
        ]);

        $this->assertSame('1e1d9e34b99c48f19974402247442ca2', $entity->getId());
        $this->assertInstanceOf(DocumentEntity::class, $entity);
    }

    public function testCanCreateNewDocumentEntityFromArray()
    {
        $entity = DocumentEntity::fromArray([]);

        $this->assertInstanceOf(DocumentEntityInterface::class, $entity);
        $this->assertInstanceOf(DocumentEntity::class, $entity);
    }

    public function testGetIdFromNewDocument()
    {
        $entity = DocumentEntity::fromArray([]);
        $id     = $entity->getId();

        $this->assertTrue((bool) preg_match('/^[a-z0-9]{32}$/', $id));
    }

    public function testSetIdFromNewDocument()
    {
        $id     = new Uuid();
        $entity = DocumentEntity::fromArray(['_id' => $id->toString()]);

        $this->assertSame($id->getHex(), $entity->getId());
    }

    public function testGetArrayCopy()
    {
        $id = new Uuid();
        $entity = DocumentEntity::fromArray(['_id' => $id->toString(), 'test_field' => 'test']);

        $this->assertSame(['id' => $id->toString(), 'test_field' => 'test'], $entity->getArrayCopy());
    }

    public function testJsonSerialize()
    {
        $id = new Uuid();
        $entity = DocumentEntity::fromArray(['_id' => $id->toString(), 'test_field' => 'test']);

        $this->assertSame('{"test_field":"test"}', json_encode($entity));
    }
}
