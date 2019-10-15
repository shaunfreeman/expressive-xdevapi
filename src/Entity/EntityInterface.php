<?php

declare(strict_types=1);

namespace XDevApi\Entity;

interface EntityInterface
{
    /**
     * Construct a new entity from array data.
     * @param array $array
     * @return static
     */
    public static function fromArray(array $array): self;

    /**
     * Gets a copy of entity as array.
     * @return array
     */
    public function getArrayCopy(): array;
}
