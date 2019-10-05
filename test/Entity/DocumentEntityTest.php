<?php /** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest\Entity;

use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use XDevApi\Entity\DocumentEntity;
use XDevApi\Entity\DocumentEntityInterface;

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
        $id     = Uuid::uuid4();
        $entity = DocumentEntity::fromArray(['_id' => $id->toString()]);

        $this->assertSame($id->getHex(), $entity->getId());
    }

    public function testGetArrayCopy()
    {
        $id = Uuid::uuid4();
        $entity = DocumentEntity::fromArray(['_id' => $id, 'test_field' => 'test']);

        $this->assertSame(['_id' => $id->toString(), 'test_field' => 'test'], $entity->getArrayCopy());
    }

    public function testJsonSerialize()
    {
        $id = Uuid::uuid4();
        $entity = DocumentEntity::fromArray(['_id' => $id, 'test_field' => 'test']);

        $this->assertSame('{"test_field":"test"}', json_encode($entity));
    }
}

