<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network;

use AndKom\Bitcoin\Address\Output\OutputInterface;

/**
 * Interface NetworkInterface
 * @package AndKom\Bitcoin\Address\Network
 */
interface NetworkInterface
{
    /**
     * @param string $pubKeyHash
     * @return string
     */
    public function getAddressP2pkh(string $pubKeyHash): string;

    /**
     * @param string $scriptHash
     * @return string
     */
    public function getAddressP2sh(string $scriptHash): string;

    /**
     * @param string $pubKeyHash
     * @return string
     */
    public function getAddressP2wpkh(string $pubKeyHash): string;

    /**
     * @param string $witnessHash
     * @return string
     */
    public function getAddressP2wsh(string $witnessHash): string;

    /**
     * @param string $address
     * @return OutputInterface
     */
    public function decodeAddress(string $address): OutputInterface;
}