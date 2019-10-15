<?php

declare(strict_types=1);

namespace XDevApi\Entity;

use JsonSerializable;

interface DocumentEntityInterface extends EntityInterface, JsonSerializable
{
    /**
     * Returns a 32 character uuid, just the hex version with no dashes.
     * @return string
     */
    public function getId(): string;

    /**
     * Returns a json string of the entity
     * @return array
     */
    public function jsonSerialize(): array;
}
