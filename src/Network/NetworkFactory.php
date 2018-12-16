<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network;

use AndKom\Bitcoin\Address\Network\Networks\Bitcoin;
use AndKom\Bitcoin\Address\Network\Networks\BitcoinTestnet;

/**
 * Class NetworkFactory
 * @package AndKom\Bitcoin\Address\Network
 */
class NetworkFactory
{
    /**
     * @var NetworkInterface
     */
    static protected $defaultNetwork;

    /**
     * @param NetworkInterface $network
     */
    static public function setDefaultNetwork(NetworkInterface $network)
    {
        static::$defaultNetwork = $network;
    }

    /**
     * @return NetworkInterface
     */
    static public function getDefaultNetwork(): NetworkInterface
    {
        return static::$defaultNetwork ?: static::bitcoin();
    }

    /**
     * @return NetworkInterface
     */
    static public function bitcoin(): NetworkInterface
    {
        return new Bitcoin();
    }

    /**
     * @return NetworkInterface
     */
    static public function bitcoinTest(): NetworkInterface
    {
        return new BitcoinTestnet();
    }

    /**
     * @return NetworkInterface
     */
    static public function bitcoinRegtest(): NetworkInterface
    {
        return new BitcoinTestnet();
    }
}