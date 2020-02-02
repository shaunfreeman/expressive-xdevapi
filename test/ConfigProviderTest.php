<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Test;

use PHPUnit\Framework\TestCase;
use ShaunFreeman\PhpMysqlXdevapi;

class ConfigProviderTest extends TestCase
{
    private $config = [
        'factories'  => [
            PhpMysqlXdevapi\DefaultSchemaFactory::class => PhpMysqlXdevapi\DefaultSchemaFactory::class,
            PhpMysqlXdevapi\SessionFactory::class       => PhpMysqlXdevapi\SessionFactory::class,
            PhpMysqlXdevapi\XDevApiOptions::class       => PhpMysqlXdevapi\XDevApiOptionsFactory::class,
        ],
    ];

    public function testProvidesExpectedConfiguration()
    {
        $provider = new PhpMysqlXdevapi\ConfigProvider();
        self::assertEquals($this->config, $provider->getDependencies());
        return $provider;
    }

    /**
     * @depends testProvidesExpectedConfiguration
     * @param PhpMysqlXdevapi\ConfigProvider $provider
     */
    public function testInvocationProvidesDependencyConfiguration(PhpMysqlXdevapi\ConfigProvider $provider)
    {
        self::assertEquals(['dependencies' => $provider->getDependencies()], $provider());
    }
}
