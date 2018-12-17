<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Output;

use AndKom\Bitcoin\Address\Exception;
use AndKom\Bitcoin\Address\Output\Outputs\P2ms;
use AndKom\Bitcoin\Address\Output\Outputs\P2pk;
use AndKom\Bitcoin\Address\Output\Outputs\P2pkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2sh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wpkh;
use AndKom\Bitcoin\Address\Output\Outputs\P2wsh;
use AndKom\Bitcoin\Address\Utils;

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

    /**
     * @param string $script
     * @return OutputInterface
     * @throws Exception
     */
    static public function fromScript(string $script): OutputInterface
    {
        $map = [
            P2pk::COMPRESSED_SCRIPT_LEN => P2pk::class,
            P2pk::UNCOMPRESSED_SCRIPT_LEN => P2pk::class,
            P2pkh::SCRIPT_LEN => P2pkh::class,
            P2sh::SCRIPT_LEN => P2sh::class,
            P2wpkh::SCRIPT_LEN => P2wpkh::class,
            P2wsh::SCRIPT_LEN => P2wsh::class,
        ];

        $scriptLen = strlen($script);

        if (isset($map[$scriptLen])) {
            $class = $map[$scriptLen];
        } elseif ($scriptLen >= P2ms::MIN_SCRIPT_LEN) {
            $class = P2ms::class;
        } else {
            throw new Exception('Unknown script type.');
        }

        return call_user_func([$class, 'fromScript'], $script);
    }

    /**
     * @param string $hex
     * @return OutputInterface
     * @throws Exception
     */
    static public function fromHex(string $hex): OutputInterface
    {
        return static::fromScript(Utils::hex2bin($hex));
    }
}