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
     * @param string $hex
     * @return string
     * @throws Exception
     */
    static public function hex2bin(string $hex): string
    {
        $bin = @hex2bin($hex);

        if (false === $bin) {
            throw new Exception('Invalid hex-encoded string.');
        }

        return $bin;
    }

    /**
     * @param string $hash
     * @param string $prefix
     * @return string
     * @throws \Exception
     */
    static public function base58encode(string $hash, string $prefix = "\x00"): string
    {
        $payload = $prefix . Validate::pubKeyHash($hash);
        $checksum = substr(static::hash256($payload), 0, 4);
        $address = $payload . $checksum;
        $base58 = (new Base58())->encode($address);
        return $base58;
    }

    /**
     * @param string $base58
     * @return array
     * @throws \Exception
     */
    static public function base58decode(string $base58): array
    {
        $address = (new Base58())->decode($base58);
        $addressLen = strlen($address);

        if (25 != $addressLen) {
            throw new Exception(sprintf('Invalid address length: %d.', $addressLen));
        }

        $payload = substr($address, 0, -4);
        $checksum = substr($address, -4);
        $checksumCheck = substr(static::hash256($payload), 0, 4);

        if ($checksum != $checksumCheck) {
            throw new Exception('Invalid checksum.');
        }

        $prefix = $payload[0];
        $hash = substr($payload, 1, 20);

        return [$hash, $prefix];
    }
}