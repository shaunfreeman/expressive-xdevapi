<?php

/** @noinspection ALL */

declare(strict_types=1);

namespace XDevApiTest;

use BadMethodCallException;
use XDevApi\XDevApiOptions;
use PHPUnit\Framework\TestCase;

final class XDevApiOptionsTest extends TestCase
{
    /**
     * @var XDevApiOptions
     */
    protected $options;

    public function setUp()
    {
        parent::setUp();
        $this->options =  XDevApiOptions::fromArray([
            'user'      => $_SERVER['MYSQL_USER'],
            'password'  => $_SERVER['MYSQL_PASSWORD'],
            'schema'    => $_SERVER['MYSQL_DATABASE'],
            'host'      => $_SERVER['MYSQL_HOST'],
        ]);
    }

    public function testCanCreateOptions()
    {
        $options = new XDevApiOptions();

        $this->assertInstanceOf(XDevApiOptions::class, $options);
    }

    public function testCanCreateFromArray()
    {
        $options = XDevApiOptions::fromArray([
            'user'      => $_SERVER['MYSQL_USER'],
            'password'  => $_SERVER['MYSQL_PASSWORD'],
            'schema'    => $_SERVER['MYSQL_DATABASE'],
            'host'      => $_SERVER['MYSQL_HOST'],
            'port'      => 33060,
        ]);

        $this->assertInstanceOf(XDevApiOptions::class, $options);
    }

    public function testCanGetAsArray()
    {
        $expectedProperties = ['user', 'password', 'schema', 'host', 'port'];

        $XDevApiOptionsArray = $this->options->toArray();

        $this->assertSame($expectedProperties, array_keys($XDevApiOptionsArray));
    }

    public function testBadPropertyCallThrowsException()
    {
        $this->expectException(BadMethodCallException::class);
        $this->options->badProperty;
    }

    public function addDataProvider()
    {
        return [
            ['user', $_SERVER['MYSQL_USER']],
            ['password', $_SERVER['MYSQL_PASSWORD']],
            ['schema', $_SERVER['MYSQL_DATABASE']],
            ['host', $_SERVER['MYSQL_HOST']],
            ['port', 33060],
        ];
    }

    /**
     * @dataProvider addDataProvider
     * @param string $property
     * @param mixed $expected
     */
    public function testPropertyCallCanGetValue(string $property, $expected)
    {
        $this->assertSame($expected, $this->options->$property);
    }
}
