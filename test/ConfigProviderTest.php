<?php

declare(strict_types=1);

namespace XDevApiTest;


use PHPUnit\Framework\TestCase;
use XDevApi;
use XDevApi\ConfigProvider;

class ConfigProviderTest extends TestCase
{
    private $config = [
        'factories'  => [
            XDevApi\DefaultSchemaFactory::class => XDevApi\DefaultSchemaFactory::class,
            XDevApi\SessionFactory::class => XDevApi\SessionFactory::class,
        ],
    ];

    public function testProvidesExpectedConfiguration()
    {
        $provider = new ConfigProvider();
        self::assertEquals($this->config, $provider->getDependencies());
        return $provider;
    }

    /**
     * @depends testProvidesExpectedConfiguration
     * @param ConfigProvider $provider
     */
    public function testInvocationProvidesDependencyConfiguration(ConfigProvider $provider)
    {
        self::assertEquals(['dependencies' => $provider->getDependencies()], $provider());
    }
}

