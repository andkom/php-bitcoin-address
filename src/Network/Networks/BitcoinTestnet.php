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
     * @var string
     */
    protected $prefixP2pkh = "\x6f";

    /**
     * @var string
     */
    protected $prefixP2sh = "\xc4";

    /**
     * @var string
     */
    protected $prefixBech32 = 'tb';
}
