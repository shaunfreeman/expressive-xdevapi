<?php /** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest\Entity;

use PHPUnit\Framework\TestCase;
use XDevApi\Entity\DocumentEntity;
use XDevApi\Entity\DocumentEntityInterface;
use XDevApi\ValueObject\Uuid;

class DocumentEntityTest extends TestCase
{
    public function testCanCreateNewDocumentEntity()
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

        $this->assertSame(['_id' => $id->toString(), 'test_field' => 'test'], $entity->getArrayCopy());
    }

    public function testJsonSerialize()
    {
        $id = new Uuid();
        $entity = DocumentEntity::fromArray(['_id' => $id->toString(), 'test_field' => 'test']);

        $this->assertSame('{"test_field":"test"}', json_encode($entity));
    }
}

