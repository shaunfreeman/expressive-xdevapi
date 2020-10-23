<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi;

/**
 * The configuration provider for the XDevApi module
 */
final class ConfigProvider
{
    public function __invoke(): array
    {
        return [
            'dependencies' => $this->getDependencies()
        ];
    }

    public function getDependencies(): array
    {
        return [
            'factories'  => [
                DefaultSchemaFactory::class => DefaultSchemaFactory::class,
                SessionFactory::class       => SessionFactory::class,
                XDevApiOptions::class       => XDevApiOptionsFactory::class,
            ],
        ];
    }
}
