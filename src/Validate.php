<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address;

/**
 * Class Validate
 * @package AndKom\Bitcoin\Address
 */
class Validate
{
    public const COMPRESSED_PUBKEY_LEN = 33;
    public const COMPRESSED_PUBKEY_PREFIXES = ["\x02", "\x03"];
    public const UNCOMPRESSED_PUBKEY_LEN = 65;
    public const UNCOMRPESSED_PUBKEY_PREFIX = "\04";
    public const PUBKEY_HASH_LEN = 20;
    public const SCRIPT_HASH_LEN = 20;
    public const WITNESS_HASH_LEN = 32;

    /**
     * @param string $pubKey
     * @return string
     * @throws Exception
     */
    public static function pubKey(string $pubKey): string
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
    public static function pubKeyHash(string $pubKeyHash): string
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
    public static function scriptHash(string $scriptHash): string
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
    public static function witnessHash(string $witnessHash): string
    {
        if (static::WITNESS_HASH_LEN != strlen($witnessHash)) {
            throw new Exception(sprintf('Invalid witness hash: %s.', bin2hex($witnessHash)));
        }

        return $witnessHash;
    }
}
