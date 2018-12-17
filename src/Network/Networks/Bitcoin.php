<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

use AndKom\Bitcoin\Address\Exception;
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
}