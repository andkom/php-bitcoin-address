<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output;

use AndKom\Bitcoin\Address\Output\Outputs\P2ms;
use AndKom\Bitcoin\Address\Output\Outputs\P2pk;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wpkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wsh;

/**
 * Class OutputFactory
 * @package AndKom\Bitcoin\Address\Output
 */
class OutputFactory
{
    /**
     * @param string $pubKey
     * @return OutputInterface
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    static public function p2pk(string $pubKey): OutputInterface
    {
        return new P2pk($pubKey);
    }

    /**
     * @param string $pubKeyHash
     * @return OutputInterface
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    static public function p2pkh(string $pubKeyHash): OutputInterface
    {
        return new P2pkh($pubKeyHash);
    }

    /**
     * @param int $m
     * @param array $pubKeys
     * @return OutputInterface
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    static public function p2ms(int $m, array $pubKeys): OutputInterface
    {
        return new P2ms($m, $pubKeys);
    }

    /**
     * @param OutputInterface $output
     * @return OutputInterface
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    static public function p2sh(OutputInterface $output): OutputInterface
    {
        return new P2sh($output);
    }

    /**
     * @param string $pubKeyHash
     * @return OutputInterface
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    static public function p2wpkh(string $pubKeyHash): OutputInterface
    {
        return new P2wpkh($pubKeyHash);
    }

    /**
     * @param OutputInterface $output
     * @return OutputInterface
     * @throws \AndKom\Bitcoin\Address\Exception
     */
    static public function p2wsh(OutputInterface $output): OutputInterface
    {
        return new P2wsh($output);
    }
}