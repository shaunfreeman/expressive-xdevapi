<?php

declare(strict_types=1);


namespace XDevApi\ValueObject;


use Exception;
use InvalidArgumentException;

final class Uuid
{
    /**
     * @var string
     */
    private $id;

    /**
     * Uuid constructor.
     * @param string|null $uuid
     * @throws Exception
     */
    public function __construct(?string $uuid = null)
    {
        if ($uuid && !$this->isValid($uuid)) {
            throw new InvalidArgumentException(sprintf('Uuid "%s" is not a valid uuid.', $uuid));
        }

        $this->id = $uuid ? $this->parse($uuid) : $this->generate();
    }

    /**
     * @param $uuid
     * @return bool
     */
    public function isValid($uuid): bool
    {
        return preg_match(
            '/^[a-f0-9]{8}-?[a-f0-9]{4}-?[a-f0-9]{4}-?[a-f0-9]{4}-?[a-f0-9]{12}$/',
            $uuid
        ) === 1;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->toString();
    }

    /**
     * @return string
     */
    public function getHex(): string
    {
        return str_replace('-', '', $this->toString());
    }

    /**
     * @param $hex
     * @return string
     */
    private function parse($hex): string
    {
        preg_match(
            '/^([a-f0-9]{8})-?([a-f0-9]{4})-?([a-f0-9]{4})-?([a-f0-9]{4})-?([a-f0-9]{12})$/',
            $hex,
            $matches
        );

        // remove first item in array match.
        array_shift($matches);

        return vsprintf('%08s-%04s-%04s-%04s-%012s', $matches);
    }

    /**
     * Cobbled together from ramsey/uuid
     * @return string
     * @throws Exception
     */
    private function generate(): string
    {
        $hex        = bin2hex(random_bytes(16));
        $timeHi     = hexdec(substr($hex, 12, 4)) & 0x0fff & ~(0xf000) | 4 << 12;
        $clockSeqHi = hexdec(substr($hex, 16, 2)) & 0x3f & ~(0xc0) | 0x80;

        $fields = [
            'time_low'                  => substr($hex, 0, 8),
            'time_mid'                  => substr($hex, 8, 4),
            'time_hi_and_version'       => dechex($timeHi),
            'clock_seq_hi_and_reserved' => dechex($clockSeqHi),
            'clock_seq_low'             => substr($hex, 18, 2),
            'node'                      => substr($hex, 20, 12),
        ];

        return vsprintf('%08s-%04s-%04s-%02s%02s-%012s', $fields);
    }
}
