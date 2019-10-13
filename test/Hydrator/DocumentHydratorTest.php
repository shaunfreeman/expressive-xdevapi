<?php /** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest\Hydrator;

use Exception;
use XDevApi\Entity\DocumentEntity;
use XDevApi\Hydrator\DocumentHydrator;
use PHPUnit\Framework\TestCase;
use Zend\Hydrator\HydratorInterface;

class DocumentHydratorTest extends TestCase
{
    private $testArray = [
        '_id' => '1e1d9e34-b99c-48f1-9974-402247442ca2',
        'test_field1' => 'test1',
        'test_field2' => 'test2',
        'test_field3' => 'test3',
    ];

    public function testCanCreateHydrator()
    {
        $hydrator = new DocumentHydrator();

        $this->assertInstanceOf(DocumentHydrator::class, $hydrator);
        $this->assertInstanceOf(HydratorInterface::class, $hydrator);
    }

    public function testExtractObjectThrowsErrorWithWrongObject()
    {
        $this->expectException(Exception::class);
        $hydrator = new DocumentHydrator();
        $data = $hydrator->extract(new \stdClass());
        $this->assertSame([], $data);
    }

    public function testCanExtractDataToArray()
    {
        $documentEntity = DocumentEntity::fromArray($this->testArray);
        $hydrator = new DocumentHydrator();
        $data = $hydrator->extract($documentEntity);
        $this->assertSame($this->testArray, $data);
    }

    public function testHydrateObjectThrowsErrorWithWrongObject()
    {
        $this->expectException(Exception::class);
        $hydrator = new DocumentHydrator();
        $data = $hydrator->hydrate($this->testArray, new \stdClass());
        $this->assertSame($this->testArray, $data);
    }

    public function testCanHydrateDataToObject()
    {
        $hydrator = new DocumentHydrator();
        $documentEntity = $hydrator->hydrate($this->testArray, new DocumentEntity);
        $this->assertSame($this->testArray, $documentEntity->getArrayCopy());
    }
}

