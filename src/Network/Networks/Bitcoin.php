<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wpkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wsh;
use AndKom\Bitcoin\Address\Utils;
use AndKom\Bitcoin\Address\Validate;
use function BitWasp\Bech32\decodeSegwit;
use function BitWasp\Bech32\encodeSegwit;

/**
 * Class Bitcoin
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Bitcoin implements NetworkInterface
{
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
     * @return string
     * @throws Exception
     */
    public function getPrefixBech32(): string
    {
        if (!$this->prefixBech32) {
            throw new Exception('Empty bech32 prefix.');
        }

        return $this->prefixBech32;
    }

    /**
     * @param string $pubKeyHash
     * @return string
     * @throws Exception
     * @throws \BitWasp\Bech32\Exception\Bech32Exception
     */
    public function getAddressP2wpkh(string $pubKeyHash): string
    {
        return encodeSegwit($this->getPrefixBech32(), 0, $pubKeyHash);
    }

    /**
     * @param string $witnessHash
     * @return string
     * @throws Exception
     * @throws \BitWasp\Bech32\Exception\Bech32Exception
     */
    public function getAddressP2wsh(string $witnessHash): string
    {
        return encodeSegwit($this->getPrefixBech32(), 0, $witnessHash);
    }

    /**
     * @param string $address
     * @return OutputInterface
     * @throws \Exception
     * @throws \BitWasp\Bech32\Exception\Bech32Exception
     */
    public function decodeAddress(string $address): OutputInterface
    {
        if ($this->prefixBech32 && 0 === strpos($address, $this->prefixBech32)) {
            list(, $hash) = decodeSegwit($this->prefixBech32, $address);
            $hashLen = strlen($hash);

            if (Validate::SCRIPT_HASH_LEN == $hashLen) {
                return new P2wpkh($hash);
            } elseif (Validate::WITNESS_HASH_LEN == $hashLen) {
                return new P2wsh($hash);
            }
        }

        list($hash, $prefix) = Utils::base58decode($address);

        if ($prefix == $this->prefixP2pkh) {
            return new P2pkh($hash);
        } elseif ($prefix == $this->prefixP2sh) {
            return new P2sh($hash);
        }

        throw new Exception('Cannot decode address.');
    }
}