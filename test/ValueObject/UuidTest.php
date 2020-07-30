<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test\ValueObject;

use InvalidArgumentException;
use ShaunFreeman\PhpMysqlXdevapi\ValueObject\Uuid;
use PHPUnit\Framework\TestCase;

class UuidTest extends TestCase
{
    private $regex = '/^([a-f0-9]{8})-([a-f0-9]{4})-([a-f0-9]{4})-([a-f0-9]{4})-([a-f0-9]{12})$/';

    public function testCanCreateUuid()
    {
        $uuid = new Uuid();
        $this->assertInstanceOf(Uuid::class, $uuid);
    }

    public function testCanGenerateNewUuid()
    {
        $uuid = new Uuid();
        $result = preg_match($this->regex, (string) $uuid);

        $this->assertTrue((bool) $result);
    }

    public function testCanCastToString()
    {
        $uuid = new Uuid();
        $this->assertIsString($uuid->toString());
    }

    public function testCanValidateUuid()
    {
        $uuid = new Uuid();
        $this->assertTrue($uuid->isValid($uuid->toString()));
    }

    public function testCanParseExistingUuid()
    {
        $uuid = new Uuid('5fd47c55b2d348bb9888f9679f18f290');
        $this->assertSame('5fd47c55-b2d3-48bb-9888-f9679f18f290', $uuid->toString());
    }

    public function testCanMalFormedUuidThrowsException()
    {
        $this->expectException(InvalidArgumentException::class);
        new Uuid('5fd4-7c55b2d34-8bb9888f-9679f18-f290');
    }

    public function testGetHex()
    {
        $uuid = new Uuid('d1ec9c0f-4bea-41a8-84eb-3d79d39e5025');
        $this->assertSame('d1ec9c0f4bea41a884eb3d79d39e5025', $uuid->getHex());
    }
}
