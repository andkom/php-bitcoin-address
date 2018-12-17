<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address;

/**
 * Class Validate
 * @package AndKom\Bitcoin\Address
 */
class Validate
{
    const COMPRESSED_PUBKEY_LEN = 33;
    const COMPRESSED_PUBKEY_PREFIXES = ["\x02", "\x03"];
    const UNCOMPRESSED_PUBKEY_LEN = 65;
    const UNCOMRPESSED_PUBKEY_PREFIX = "\04";
    const PUBKEY_HASH_LEN = 20;

    /**
     * @param string $pubKey
     * @return string
     * @throws Exception
     */
    static public function pubKey(string $pubKey): string
    {
        $len = strlen($pubKey);

        if (
            (
                static::COMPRESSED_PUBKEY_LEN != $len ||
                !in_array($pubKey[0], static::COMPRESSED_PUBKEY_PREFIXES)
            ) &&
            (
                static::UNCOMPRESSED_PUBKEY_LEN != $len ||
                static::UNCOMRPESSED_PUBKEY_PREFIX != $pubKey[0]
            )
        ) {
            throw new Exception(sprintf('Invalid pubkey: %s.', bin2hex($pubKey)));
        }

        return $pubKey;
    }

    /**
     * @param string $pubKeyHash
     * @return string
     * @throws Exception
     */
    static public function pubKeyHash(string $pubKeyHash): string
    {
        if (static::PUBKEY_HASH_LEN != strlen($pubKeyHash)) {
            throw new Exception(sprintf('Invalid pubkey hash: %s.', bin2hex($pubKeyHash)));
        }

        return $pubKeyHash;
    }
}