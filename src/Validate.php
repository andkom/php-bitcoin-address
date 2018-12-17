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
    const SCRIPT_HASH_LEN = 20;
    const WITNESS_HASH_LEN = 32;

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

    /**
     * @param string $scriptHash
     * @return string
     * @throws Exception
     */
    static public function scriptHash(string $scriptHash): string
    {
        if (static::SCRIPT_HASH_LEN != strlen($scriptHash)) {
            throw new Exception(sprintf('Invalid script hash: %s.', bin2hex($scriptHash)));
        }

        return $scriptHash;
    }

    /**
     * @param string $witnessHash
     * @return string
     * @throws Exception
     */
    static public function witnessHash(string $witnessHash): string
    {
        if (static::WITNESS_HASH_LEN != strlen($witnessHash)) {
            throw new Exception(sprintf('Invalid witness hash: %s.', bin2hex($witnessHash)));
        }

        return $witnessHash;
    }
}