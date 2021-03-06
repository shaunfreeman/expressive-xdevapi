<?php

declare(strict_types=1);

namespace ShaunFreeman\PhpMysqlXdevapi\Hydrator;

use Exception;
use Laminas\Hydrator\HydratorInterface;
use ShaunFreeman\PhpMysqlXdevapi\Entity\DocumentEntityInterface;

final class DocumentHydrator implements HydratorInterface
{
    /**
     * @param object|DocumentEntityInterface $object
     * @return array
     * @throws Exception
     */
    public function extract(object $object): array
    {
        if (!$object instanceof DocumentEntityInterface) {
            throw new Exception(sprintf(
                'Class: "%s" needs to implement %s',
                get_class($object),
                DocumentEntityInterface::class
            ));
        }

        return $object->getArrayCopy();
    }

    /**
     * @param array $data
     * @param object|DocumentEntityInterface $object
     * @return object|DocumentEntityInterface
     * @throws Exception
     */
    public function hydrate(array $data, object $object): DocumentEntityInterface
    {
        if (!$object instanceof DocumentEntityInterface) {
            throw new Exception(sprintf(
                'Class: "%s" needs to implement %s',
                get_class($object),
                DocumentEntityInterface::class
            ));
        }

        return $object::fromArray($data);
    }
}
