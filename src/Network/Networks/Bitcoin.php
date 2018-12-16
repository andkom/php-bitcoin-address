<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Utils;
use function BitWasp\Bech32\encodeSegwit;

/**
 * Class Bitcoin
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class Bitcoin implements NetworkInterface
{
    /**
     * @var int
     */
    protected $prefixP2pkh = 0x00;

    /**
     * @var int
     */
    protected $prefixP2sh = 0x05;

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
        return Utils::base58address($pubKeyHash, $this->prefixP2pkh);
    }

    /**
     * @param string $scriptHash
     * @return string
     * @throws \Exception
     */
    public function getAddressP2sh(string $scriptHash): string
    {
        return Utils::base58address($scriptHash, $this->prefixP2sh);
    }

    /**
     * @param string $pubKeyHash
     * @return string
     * @throws \BitWasp\Bech32\Exception\Bech32Exception
     */
    public function getAddressP2wpkh(string $pubKeyHash): string
    {
        return encodeSegwit($this->prefixBech32, 0, $pubKeyHash);
    }

    /**
     * @param string $witnessScriptHash
     * @return string
     * @throws \BitWasp\Bech32\Exception\Bech32Exception
     */
    public function getAddressP2wsh(string $witnessScriptHash): string
    {
        return encodeSegwit($this->prefixBech32, 0, $witnessScriptHash);
    }
}