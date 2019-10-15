<?php

declare(strict_types=1);

namespace XDevApi\Entity;

use Exception;
use XDevApi\ValueObject\Uuid;

final class DocumentEntity implements DocumentEntityInterface
{
    /**
     * @var Uuid
     */
    private $id;

    /**
     * @var array
     */
    private $doc = [];

    /**
     * @param string|null $id
     * @param array $doc
     * @throws Exception
     */
    public function __construct(?string $id = null, array $doc = [])
    {
        $this->id = new Uuid($id);
        $this->doc = $doc;
    }

    /**
     * Returns a 32 character uuid, just the hex version with no dashes.
     * @return string
     */
    public function getId(): string
    {
        return $this->id->getHex();
    }

    /**
     * Gets a copy of entity as array.
     * @return array
     */
    public function getArrayCopy(): array
    {
        $array = [];
        $array['id'] = (string) $this->id;
        return array_merge($array, $this->doc);
    }

    /**
     * Returns a json string of the entity
     * @return array
     */
    public function jsonSerialize(): array
    {
        return $this->doc;
    }

    /**
     * Construct a new entity from array data.
     * @param array $array
     * @return static|DocumentEntity
     * @throws Exception
     */
    public static function fromArray(array $array): EntityInterface
    {
        $uuid = $array['_id'] ?? $array['id'] ?? null;
        unset($array['_id'], $array['id']);

        $entity = new static($uuid, $array);

        return $entity;
    }
}
