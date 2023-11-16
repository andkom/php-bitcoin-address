<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network;

use AndKom\Bitcoin\Address\Exception;

/**
 * Class NetworkFactory
 * @package AndKom\Bitcoin\Address\Network
 * @method static NetworkInterface bitcoin()
 * @method static NetworkInterface bitcoinTestnet()
 * @method static NetworkInterface bitcoinCash()
 * @method static NetworkInterface bitcoinGold()
 * @method static NetworkInterface clams()
 * @method static NetworkInterface litecoin()
 * @method static NetworkInterface litecoinTestnet()
 * @method static NetworkInterface dogecoin()
 * @method static NetworkInterface dogecoinTestnet()
 * @method static NetworkInterface viacoin()
 * @method static NetworkInterface viacoinTestnet()
 * @method static NetworkInterface dash()
 * @method static NetworkInterface dashTestnet()
 * @method static NetworkInterface zcash()
 */
class NetworkFactory
{
    /**
     * @var string[]
     */
    protected static $networks = [
        'bitcoin',
        'bitcoinTestnet',
        'bitcoinCash',
        'bitcoinGold',
        'clams',
        'litecoin',
        'litecoinTestnet',
        'dogecoin',
        'dogecoinTestnet',
        'viacoin',
        'viacoinTestnet',
        'dash',
        'dashTestnet',
        'zcash',
    ];

    /**
     * @var NetworkInterface
     */
    protected static $defaultNetwork;

    /**
     * @param NetworkInterface $network
     */
    public static function setDefaultNetwork(NetworkInterface $network): void
    {
        static::$defaultNetwork = $network;
    }

    /**
     * @return NetworkInterface
     */
    public static function getDefaultNetwork(): NetworkInterface
    {
        return static::$defaultNetwork ?: static::bitcoin();
    }

    /**
     * @param string $name
     * @param array<mixed> $arguments
     * @return NetworkInterface
     * @throws Exception
     */
    public function createNetwork(string $name, array $arguments): NetworkInterface
    {
        if (!in_array($name, static::$networks)) {
            throw new Exception(sprintf('Invalid network name: %s.', $name));
        }

        $class = 'AndKom\\Bitcoin\\Address\\Network\\Networks\\' . ucfirst($name);

        $network = new $class(...$arguments);

        if (! $network instanceof NetworkInterface) {
            throw new Exception("{$class} was not a NetworkInterface");
        }

        return $network;
    }

    /**
     * @param string $name
     * @param array<mixed> $arguments
     * @return NetworkInterface
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        return $this->createNetwork($name, $arguments);
    }

    /**
     * @param string $name
     * @param array<mixed> $arguments
     * @return NetworkInterface
     */
    public static function __callStatic(string $name, array $arguments)
    {
        return (new NetworkFactory())->createNetwork($name, $arguments);
    }
}
