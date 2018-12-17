<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address;

use StephenHill\Base58;

/**
 * Class Utils
 * @package AndKom\Bitcoin\Address
 */
class Utils
{
    const HASH160_LEN = 20;

    /**
     * @param string $data
     * @return string
     */
    static public function sha256(string $data): string
    {
        return hash('sha256', $data, true);
    }

    /**
     * @param string $data
     * @return string
     */
    static public function hash256(string $data): string
    {
        return static::sha256(static::sha256($data));
    }

    /**
     * @param string $data
     * @return string
     */
    static public function hash160(string $data): string
    {
        return hash('ripemd160', static::sha256($data), true);
    }

    /**
     * @param string $hash
     * @param string $prefix
     * @return string
     * @throws \Exception
     */
    static public function base58address(string $hash, string $prefix = "\x00"): string
    {
        if (static::HASH160_LEN != strlen($hash)) {
            throw new Exception('Invalid hash length.');
        }

        $payload = $prefix . $hash;
        $checksum = substr(static::hash256($payload), 0, 4);
        $address = $payload . $checksum;
        $encoded = (new Base58())->encode($address);

        return $encoded;
    }
}