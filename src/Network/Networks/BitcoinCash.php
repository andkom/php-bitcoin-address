<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Output\OutputInterface;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use CashAddr\CashAddress;

/**
 * Class BitcoinCash
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class BitcoinCash extends Bitcoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = 'bitcoincash';

    /**
     * @var string
     */
    protected $prefixP2sh = 'bitcoincash';

    /**
     * @var string
     */
    protected $prefixBech32 = null;

    /**
     * @param string $pubKeyHash
     * @return string
     * @throws \CashAddr\Exception\Base32Exception
     * @throws \CashAddr\Exception\CashAddressException
     */
    public function getAddressP2pkh(string $pubKeyHash): string
    {
        return CashAddress::encode($this->prefixP2pkh, 'pubkeyhash', $pubKeyHash);
    }

    /**
     * @param string $scriptHash
     * @return string
     * @throws \CashAddr\Exception\Base32Exception
     * @throws \CashAddr\Exception\CashAddressException
     */
    public function getAddressP2sh(string $scriptHash): string
    {
        return CashAddress::encode($this->prefixP2sh, 'scripthash', $scriptHash);
    }

    /**
     * @param string $address
     * @return OutputInterface
     * @throws Exception
     * @throws \CashAddr\Exception\Base32Exception
     * @throws \CashAddr\Exception\CashAddressException
     */
    public function decodeAddress(string $address): OutputInterface
    {
        if (strpos($address, $this->prefixP2pkh) !== 0 ||
            strpos($address, $this->prefixP2sh) !== 0) {
            throw new Exception('Cannot decode address.');
        }

        list(, $scriptType, $hash) = CashAddress::decode($address);

        if ($scriptType == 'pubkeyhash') {
            return new P2pkh($hash);
        } else {
            return new P2sh($hash);
        }
    }
}