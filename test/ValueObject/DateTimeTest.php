<?php /** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest\ValueObject;

use DateTimeImmutable;
use JsonSerializable;
use XDevApi\ValueObject\DateTime;
use PHPUnit\Framework\TestCase;

class DateTimeTest extends TestCase
{
    public function testCanCreateDateTime()
    {
        $datetime = new DateTime();
        $this->assertInstanceOf(DateTime::class, $datetime);
        $this->assertInstanceOf(DateTimeImmutable::class, $datetime);
    }

    public function testWillBeRenderedAsW3CDate()
    {
        $now = new DateTimeImmutable('now');
        $dateTime = new DateTime($now->format(DateTime::W3C));
        $this->assertSame($now->format(DateTimeImmutable::W3C), $dateTime->toString());
    }

    public function testCanGetAsJsonString()
    {
        $now = new DateTimeImmutable('now');
        $dateTime = new DateTime($now->format(DateTime::W3C));
        $this->assertInstanceOf(JsonSerializable::class, $dateTime);
        $this->assertSame(sprintf('"%s"', $now->format(DateTimeImmutable::W3C)), json_encode($dateTime));
    }
}

