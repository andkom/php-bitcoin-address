<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class BitcoinTestnet
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class BitcoinTestnet extends Bitcoin
{
    /**
     * @var int
     */
    protected $prefixP2pkh = 0x6f;

    /**
     * @var int
     */
    protected $prefixP2sh = 0xc4;

    /**
     * @var string
     */
    protected $prefixBech32 = 'tb';
}