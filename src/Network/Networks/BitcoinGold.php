<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class BitcoinGold
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class BitcoinGold extends Bitcoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x26";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x17";

    /**
     * @var null
     */
    protected $prefixBech32 = 'btg';
}