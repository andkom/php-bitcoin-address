<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

use AndKom\Bitcoin\Address\Output\OutputInterface;
use CashAddr\CashAddress;

/**
 * Class BitcoinCash
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class BitcoinCash extends Bitcoin
{
    /**
     * @var null
     */
    protected $prefixBech32 = 'bitcoincash';

    /**
     * @param string $pubKeyHash
     * @return string
     * @throws \CashAddr\Exception\Base32Exception
     * @throws \CashAddr\Exception\CashAddressException
     */
    public function getAddressP2wpkh(string $pubKeyHash): string
    {
        return CashAddress::encode($this->prefixBech32, 'pubkeyhash', $pubKeyHash);
    }

    /**
     * @param OutputInterface $output
     * @return string
     * @throws \CashAddr\Exception\Base32Exception
     * @throws \CashAddr\Exception\CashAddressException
     */
    public function getAddressP2wsh(OutputInterface $output): string
    {
        return CashAddress::encode($this->prefixBech32, 'scripthash', $output->hash());
    }
}