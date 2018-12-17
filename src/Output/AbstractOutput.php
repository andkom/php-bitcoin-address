<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Network\NetworkFactory;
use AndKom\Bitcoin\Address\Network\NetworkInterface;
use AndKom\Bitcoin\Address\Utils;

/**
 * Class AbstractOutput
 * @package AndKom\Bitcoin\Address\Output
 */
abstract class AbstractOutput implements OutputInterface
{
    /**
     * @return string
     */
    public function hex(): string
    {
        return bin2hex($this->script());
    }

    /**
     * @return string
     */
    public function hash(): string
    {
        return Utils::hash160($this->script());
    }

    /**
     * @return string
     */
    public function witnessHash(): string
    {
        return Utils::sha256($this->script());
    }

    /**
     * @param NetworkInterface|null $network
     * @return NetworkInterface
     */
    protected function network(NetworkInterface $network = null): NetworkInterface
    {
        return $network ?: NetworkFactory::getDefaultNetwork();
    }

    /**
     * @param string $hex
     * @return OutputInterface
     * @throws Exception
     */
    static public function fromHex(string $hex): OutputInterface
    {
        $script = hex2bin($hex);

        if ($script === false) {
            throw new Exception('Invalid hex-encoded string.');
        }

        return static::fromScript($script);
    }
}