<?php

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
        $this->options =  new XDevApiOptions(
            $_SERVER['MYSQL_USER'],
            $_SERVER['MYSQL_PASSWORD'],
            $_SERVER['MYSQL_DATABASE'],
            $_SERVER['MYSQL_HOST'],
            33060
        );
    }

    public function testCanCreateOptions()
    {
        $options = new XDevApiOptions(
            $_SERVER['MYSQL_USER'],
            $_SERVER['MYSQL_PASSWORD'],
            $_SERVER['MYSQL_DATABASE'],
            $_SERVER['MYSQL_HOST'],
        );

        $this->assertInstanceOf(XDevApiOptions::class, $options);
    }

    public function testCanCreateFromArray()
    {
        $options = XDevApiOptions::fromArray([
            'user'      => $_SERVER['MYSQL_USER'],
            'password'  => $_SERVER['MYSQL_PASSWORD'],
            'schema'    => $_SERVER['MYSQL_DATABASE'],
            'host'      => $_SERVER['MYSQL_HOST'],
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
        $badCall = $this->options->badProperty;
    }

    public function testCanGetUser()
    {
        $this->assertSame('dbuser', $this->options->user);
    }

    public function testCanGetPassword()
    {
        $this->assertSame('654321', $this->options->password);
    }

    public function testCanGetSchema()
    {
        $this->assertSame('dbname', $this->options->schema);
    }

    public function testCanGetHost()
    {
        $this->assertSame('mysql', $this->options->host);
    }

    public function testCanGetPort()
    {
        $this->assertSame(33060, $this->options->port);
    }
}

