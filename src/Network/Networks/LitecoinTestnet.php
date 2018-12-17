<?php

declare(strict_types=1);

namespace AndKom\Bitcoin\Address\Network\Networks;

/**
 * Class LitecoinTestnet
 * @package AndKom\Bitcoin\Address\Network\Networks
 */
class LitecoinTestnet extends Litecoin
{
    /**
     * @var string
     */
    protected $prefixP2pkh = "\x6f";

    /**
     * @var string
     */
    protected $prefixP2sh = "\x3a"; // "\xc4"

    /**
     * @var string
     */
    protected $prefixBech32 = 'tltc';
}