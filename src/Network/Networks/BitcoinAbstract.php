<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use AndKom\Bitcoin\Address\Output\Outputs\P2tr;
use AndKom\Bitcoin\Address\Output\Outputs\P2wpkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wsh;
use AndKom\Bitcoin\Address\Utils;
use AndKom\Bitcoin\Address\Validate;
use BrooksYang\Bech32m\Exception\Bech32mException;

use function BrooksYang\Bech32m\decodeSegwit;
use function BrooksYang\Bech32m\encodeSegwit;

use const BrooksYang\Bech32m\BECH32;
use const BrooksYang\Bech32m\BECH32M;

/**
 * Class BitcoinAbstract
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
abstract class BitcoinAbstract implements NetworkInterface
{
    public const VERSION_SEGWIT = 0;
    public const VERSION_TAPROOT = 1;

    /**
     * @var string
     */
    protected $prefixP2pkh = "\x00";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x05";

    /**
     * @var string
     */
    protected $prefixBech32 = 'bc';

    /**
     * @var bool
     */
    protected $hasSegwit = false;

    /**
     * @var bool
     */
    protected $hasTaproot = false;

    /**
     * @param string $pubKeyHash
     * @return string
     * @throws \Exception
     */
    public function getAddressP2pkh(string $pubKeyHash): string
    {
        return Utils::base58encode($pubKeyHash, $this->prefixP2pkh);
    }

    /**
     * @param string $scriptHash
     * @return string
     * @throws \Exception
     */
    public function getAddressP2sh(string $scriptHash): string
    {
        return Utils::base58encode($scriptHash, $this->prefixP2sh);
    }

    /**
     * @param string $pubKeyHash
     * @return string
     * @throws Exception
     * @throws Bech32mException
     */
    public function getAddressP2wpkh(string $pubKeyHash): string
    {
        if (!$this->hasSegwit) {
            throw new Exception('Segwit is not supported.');
        }

        return encodeSegwit($this->prefixBech32, 0, $pubKeyHash, BECH32);
    }

    /**
     * @param string $witnessHash
     * @return string
     * @throws Exception
     * @throws Bech32mException
     */
    public function getAddressP2wsh(string $witnessHash): string
    {
        if (!$this->hasSegwit) {
            throw new Exception('Segwit is not supported.');
        }

        return encodeSegwit($this->prefixBech32, 0, $witnessHash, BECH32);
    }

    /**
     * @param string $taprootPubKey
     * @return string
     * @throws Bech32mException
     * @throws Exception
     */
    public function getAddressP2tr(string $taprootPubKey): string
    {
        if (!$this->hasTaproot) {
            throw new Exception('Taproot is not supported.');
        }

        return encodeSegwit($this->prefixBech32, 1, $taprootPubKey, BECH32M);
    }

    /**
     * @param string $address
     * @return OutputInterface
     * @throws \Exception
     * @throws Bech32mException
     */
    public function decodeAddress(string $address): OutputInterface
    {
        // decode segwit
        if ($this->hasSegwit && 0 === strpos($address, $this->prefixBech32)) {
            try {
                list($version, $hash) = decodeSegwit($this->prefixBech32, $address, BECH32);

                if ($version === static::VERSION_SEGWIT) {
                    $hashLen = strlen($hash);

                    if (Validate::SCRIPT_HASH_LEN == $hashLen) {
                        return new P2wpkh($hash);
                    } elseif (Validate::WITNESS_HASH_LEN == $hashLen) {
                        return new P2wsh($hash);
                    }
                }
            } catch (\Exception $exception) {
            }
        }

        // decode taproot
        if ($this->hasTaproot && 0 === strpos($address, $this->prefixBech32)) {
            try {
                list($version, $hash) = decodeSegwit($this->prefixBech32, $address, BECH32M);

                if ($version === static::VERSION_TAPROOT) {
                    return new P2tr($hash);
                }
            } catch (\Exception $exception) {
            }
        }

        // decode legacy
        try {
            list($hash, $prefix) = Utils::base58decode($address);

            if ($prefix == $this->prefixP2pkh) {
                return new P2pkh($hash);
            } elseif ($prefix == $this->prefixP2sh) {
                return new P2sh($hash);
            }
        } catch (\Exception $exception) {
        }

        throw new Exception('Cannot decode address.');
    }

    /**
     * @param string $address
     * @return bool
     */
    public function validateAddress(string $address): bool
    {
        try {
            static::decodeAddress($address);
            return true;
        } catch (\Exception $exception) {
            return false;
        }
    }
}
