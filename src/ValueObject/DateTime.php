<?php

declare(strict_types=1);


namespace XDevApi\ValueObject;


use DateTimeImmutable;
use JsonSerializable;

class DateTime extends DateTimeImmutable implements JsonSerializable
{
    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->format(self::W3C);
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->toString();
    }
}
