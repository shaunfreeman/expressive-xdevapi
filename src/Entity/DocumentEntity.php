<?php

declare(strict_types=1);


namespace XDevApi\Entity;


use Exception;
use Ramsey\Uuid\Uuid;

final class DocumentEntity implements DocumentEntityInterface
{
    /**
     * @var Uuid
     */
    private $_id;

    /**
     * @var array
     */
    private $doc = [];

    /**
     * DocumentEntity constructor.
     * @throws Exception
     */
    private function __construct()
    {
        $this->_id = Uuid::uuid4();
    }

    /**
     * Returns a 32 character uuid, just the hex version with no dashes.
     * @return string
     */
    public function getId(): string
    {
        return $this->_id->getHex();
    }

    /**
     * Gets a copy of entity as array.
     * @return array
     */
    public function getArrayCopy(): array
    {
        $array = [];
        $array['_id'] = (string) $this->_id;
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
        $entity = new static();

        if (array_key_exists('_id', $array)) {
            $entity->_id = Uuid::fromString($array['_id']);
            unset($array['_id']);
        }

        $entity->doc = $array;

        return $entity;
    }
}
