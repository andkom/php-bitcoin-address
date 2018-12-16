<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network;

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
     * @param string $hash
     * @return string
     */
    public function getAddressP2sh(string $hash): string;

    /**
     * @param string $hash
     * @return string
     */
    public function getAddressP2wpkh(string $hash): string;

    /**
     * @param string $hash
     * @return string
     */
    public function getAddressP2wsh(string $hash): string;
}