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
     * @param string $hash
     * @return string
     */
    public function getAddressP2pkh(string $hash): string;

    /**
     * @param OutputInterface $output
     * @return string
     */
    public function getAddressP2sh(OutputInterface $output): string;

    /**
     * @param string $hash
     * @return string
     */
    public function getAddressP2wpkh(string $hash): string;

    /**
     * @param OutputInterface $output
     * @return string
     */
    public function getAddressP2wsh(OutputInterface $output): string;
}