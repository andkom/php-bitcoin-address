<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

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
}